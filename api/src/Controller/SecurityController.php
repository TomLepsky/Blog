<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route(path="/api/login", name="app_login", methods={"POST"});
     * @param Request $request
     * @return Response
     */
    public function login(Request $request) : Response
    {
        $userData = json_decode($request->getContent());
        if (!isset($userData->login, $userData->password)) {
            throw new AuthenticationException('You should pass two parameters: login and password.');
        }

        if (!($user = $this->getUser())) {
            throw new AuthenticationException("Authentication failed!");
        }

        return $this->json([
            'status' => 200,
            'data' => [
                'user' => $user->getUserIdentifier()
            ]
        ]);
    }

    /**
     * @param string $token
     * @return ResponseInterface
     * @throws Exception
     */
    public function getResponseByToken(string $token) : ResponseInterface
    {
        return $this->makeRequest(
            getenv('REMOTE_AUTH_SERVER_ADDR') . getenv('URI_GET_BY_TOKEN'),
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-AUTH-TOKEN' => $token,
                ],
            ]
        );
    }

    /**
     * @Route(path="/refresh", methods={"POST"});
     * @param string $token
     * @return ResponseInterface
     * @throws Exception
     */
    public function refreshToken(string $token) : ResponseInterface
    {
        return $this->makeRequest(
            getenv('REMOTE_AUTH_SERVER_ADDR') . getenv('URI_REFRESH_TOKEN'),
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-AUTH-TOKEN' => $token,
                ],
            ]
        );
    }

    private function makeRequest(string $url, array $options) : ResponseInterface
    {
        $client = HttpClient::create();
        $response = $client->request('POST', $url, $options);

        if (401 === $response->getStatusCode()) {
            throw new UserNotFoundException("There is no user with such token or you token has expired.");
        }

        if (404 === $response->getStatusCode()) {
            throw new NotFoundHttpException('Not available address for remote authorization server ');
        }

        if ($response->getStatusCode() >= 400) {
            throw new \Exception($response->getContent());
        }

        return $response;
    }

    /**
     * @Route("/api/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void {}
}
