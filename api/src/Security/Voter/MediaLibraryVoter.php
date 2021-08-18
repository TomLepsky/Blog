<?php

namespace App\Security\Voter;

use App\Entity\MediaLibrary;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class MediaLibraryVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, VoterAttribute::getAttributes()) && $subject instanceof MediaLibrary;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (null === $user || (!$user instanceof UserInterface)) {
            throw new AuthenticationException('Authentication failed!');
        }

        $permissions = $user->getPermissions();
        return isset($permissions[MediaLibrary::class]) ? $permissions[MediaLibrary::class]->{$attribute} ?? false : false;
    }
}
