<?php

namespace App\Security\Voter;

use App\Entity\Tool;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class ToolVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, VoterAttribute::getAttributes()) && $subject instanceof Tool;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (null === $user || (!$user instanceof UserInterface)) {
            throw new AuthenticationException('Authentication failed!');
        }

        $permissions = $user->getPermissions();
        return isset($permissions[Tool::class]) ? $permissions[Tool::class]->{$attribute} ?? false : false;
    }
}
