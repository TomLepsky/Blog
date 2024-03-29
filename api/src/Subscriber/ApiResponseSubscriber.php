<?php

namespace App\Subscriber;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use ApiPlatform\Core\Exception\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiResponseSubscriber implements EventSubscriberInterface
{
    private ?int $totalItems = null;

    private array $excludedRoutes = [
        'api_entrypoint',
        'api_doc',
        'app_swaggerui_docs',
        'app_login',
        'app_logout'
    ];

    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 20],
            KernelEvents::RESPONSE => ['onKernelResponse', 10],
            KernelEvents::EXCEPTION => ['onKernelException', 1]
        ];
    }

    public function onKernelView(ViewEvent $event) : void
    {
        $paginator = $event->getControllerResult();
        if ($paginator instanceof Paginator) {
            $this->totalItems = $paginator->getTotalItems();
        }
    }

    public function onKernelResponse(ResponseEvent $event) : void
    {
        $context = $event->getRequest()->attributes->get('_api_normalization_context');
        $route = $event->getRequest()->attributes->get('_route');
        $acceptFormat = $event->getRequest()->headers->get('accept-format');
        if (!in_array($route, $this->excludedRoutes) && $acceptFormat === 'wv.api+json') {
            $responseObject = $event->getResponse();
            $statusCode = $responseObject->getStatusCode();
            if ($statusCode < 300) {
                $content = json_decode($responseObject->getContent());
                $response = [
                    'status' => $statusCode,
                    'data' => $content
                ];
                if ('collection' === $context['operation_type'] && $this->totalItems !== null) {
                    $response['meta']['total'] = $this->totalItems;
                }

                $responseObject->setContent(json_encode($response));
            } elseif ($statusCode > 399 && $statusCode < 500 && $statusCode !== 404) {
                $content = json_decode($responseObject->getContent());
                $errorDetails = [];
                if (isset($content->violations)) {
                    foreach ($content->violations as $violation) {
                        $errorDetails[] = [
                            'field' => $violation->propertyPath,
                            'issue' => $violation->message
                        ];
                    }
                } elseif (isset($content->detail)) {
                    $errorDetails[] = [
                        'issue' => $content->detail
                    ];
                } elseif (isset($content->error->message)) {
                    $errorDetails[] = [
                        'issue' => $content->error->message
                    ];
                }

                $error = [
                    'name' => 'validation_error',
                    'message' => 'An error occurred',
                ];

                if (!empty($errorDetails)) {
                    $error['details'] = $errorDetails;
                }

                $response = [
                    'status' => $statusCode,
                    'error' => $error
                ];

                $responseObject->setContent(json_encode($response));
            }
        }
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        switch (true) {
            case $exception instanceof NotFoundHttpException:
                $response->setStatusCode(404);
                $response->setData(
                    [
                        'status' => 404,
                        'error' => [
                            'name' => 'not_found',
                            'message' => $exception->getMessage(),
                        ],
                    ]
                );
                break;
            case $exception instanceof NotEncodableValueException:
                $response->setStatusCode(400);
                $response->setData(
                    [
                        'status' => 400,
                        'error' => [
                            'name' => 'syntax_error',
                            'message' => 'JSON syntax error',
                        ],
                    ]
                );
                break;
            case $exception instanceof InvalidArgumentException:
                $response->setStatusCode(400);
                $response->setData(
                    [
                        'status' => 400,
                        'error' => [
                            'name' => 'invalid_type',
                            'message' => $exception->getMessage(),
                        ],
                    ]
                );
                break;
            case $exception instanceof HttpExceptionInterface:
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
                $response->setData(
                    [
                        'status' => $exception->getStatusCode(),
                        'error' => [
                            'name' => 'http_exception',
                            'message' => $exception->getMessage(),
                        ],
                    ]
                );
                break;
            case $exception instanceof AuthenticationException:
            case $exception instanceof AccessDeniedException:
                $response->setStatusCode(401);
                $response->setData(
                    [
                        'status' => 401,
                        'error' => [
                            'name' => 'authentication_error',
                            'message' => $exception->getMessage(),
                        ],
                    ]
                );
                break;
            default:
                $response->setStatusCode(500);
                $response->setData(
                    [
                        'status' => 500,
                        'error' => [
                            'name' => 'server_error',
                            'message' => $exception->getMessage(),
                        ],
                    ]
                );
        }

        $event->setResponse($response);
    }
}
