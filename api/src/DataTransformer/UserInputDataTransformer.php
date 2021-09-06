<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\UserInput;
use App\Security\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserInputDataTransformer implements DataTransformerInterface
{

    public function transform($object, string $to, array $context = []) : UserInterface
    {
        $user = new User();
        $user->setId($object->id);
        $user->setLogin($object->login);
        $user->setPassword($object->password);
        $user->setIsAdmin($object->isAdmin);
        $user->setToken($object->token);
        $user->setPermissions($object->permissions);

        return $user;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $data instanceof UserInput && $to === User::class;
    }
}
