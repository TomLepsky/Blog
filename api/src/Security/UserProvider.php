<?php

namespace App\Security;

use App\Controller\SecurityController;
use App\DataTransformer\UserInputDataTransformer;
use App\DTO\UserInput;
use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\Tool;
use stdClass;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    public function __construct(
        private UserInputDataTransformer $dataTransformer,
        private SecurityController $controller,
        private PasswordHasherFactoryInterface $hasherFactory
    ) {}

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
//        $content = json_decode($this->controller->getResponseByToken($identifier));
        throw new UserNotFoundException("No API token supported now. Please use login form instead!");
        $content = new StdClass();
        $content->id = 1;
        $content->login = 'root';
        $content->password = '$2y$13$hv8NxKD8bTicwDjjcu9QHe4jPdhxTfiIGrNaaLwK44q3udGX.efsC'; //root
        $content->isAdmin = true;
        $content->token = 'token';

        $permissions = new StdClass();
        $permissions->canRead = true;
        $permissions->canWrite = true;
        $permissions->canEdit = true;
        $permissions->canDelete = true;

        $content->permissions = [
            Article::class => $permissions
        ];

        $userInput = new UserInput();
        $userInput->id = $content->id;
        $userInput->login = $content->login;
        $userInput->password = $content->password;
        $userInput->isAdmin = $content->isAdmin ?? false;
        $userInput->permissions = $content->permissions ?? [];
        $userInput->token = $content->token ?? null;

        $user = $this->dataTransformer->transform($userInput, User::class);

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

    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
    }

    public function loadUserByUsername(string $username) : UserInterface
    {
        trigger_deprecation('symfony/doctrine-bridge', '5.3', 'Method "%s()" is deprecated, use loadUserByIdentifier() instead.', __METHOD__);

        return $this->loadUserByIdentifier($username);
    }
}
