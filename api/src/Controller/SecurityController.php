<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route(path="/login", methods={"POST"});
     * @param Request $request
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function login(Request $request): ResponseInterface
    {
        $userData = json_decode($request->getContent());

        if (!isset($userData->login, $userData->password)) {
            throw new AuthenticationException('You should pass two parameters: login and password.');
        }

        $client = HttpClient::create();
        return $client->request(
            'POST',
            getenv('REMOTE_AUTH_SERVER_ADDR') . getenv('URI_LOGIN'),
            [
                'json' => [
                    'login' => $userData->login,
                    'password' => $userData->password
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
            ]
        );
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
}
