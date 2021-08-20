<?php

namespace App\Security;

use App\Controller\SecurityController;
use App\DataTransformer\UserInputDataTransformer;
use App\DTO\UserInput;
use App\Entity\Tag;
use App\Entity\Tool;
use stdClass;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private UserInputDataTransformer $dataTransformer;
    private SecurityController $controller;

    public function __construct(UserInputDataTransformer $dataTransformer, SecurityController $controller)
    {
        $this->dataTransformer = $dataTransformer;
        $this->controller = $controller;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {

        $content = json_decode($this->controller->getResponseByToken($identifier));

        $userInput = new UserInput();
        $userInput->id = $content->id;
        $userInput->login = $content->login;
        $userInput->isAdmin = $content->isAdmin ?? false;
        $userInput->permissions = $content->permissions ?? [];
        $userInput->token = $content->token ?? null;

        return $this->dataTransformer->transform($userInput, User::class);
    }

    public function refreshUser(UserInterface $user) : UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class) : bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    private function makeRequest(string $url, array $options) : ResponseInterface
    {


        return $response;
    }

    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
    }

    public function loadUserByUsername(string $username) : UserInterface
    {
        // TODO: Implement loadUserByUsername() method.
    }
}
