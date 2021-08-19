<?php

namespace App\Security\Voter;

use App\Entity\MediaObject;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class MediaObjectVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, VoterAttribute::getAttributes()) && $subject instanceof MediaObject;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if ($token instanceof NullToken) {
            throw new AuthenticationException('No API token provided');
        }

        $user = $token->getUser();
        if (null === $user || (!$user instanceof UserInterface)) {
            throw new AuthenticationException('Authentication failed!');
        }

        $permissions = $user->getPermissions();
        return isset($permissions[MediaObject::class]) ? $permissions[MediaObject::class]->{$attribute} ?? false : false;
    }
}
