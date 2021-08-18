<?php

namespace App\Security\Voter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Entity\Tag;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class TagVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        if ($subject instanceof Paginator) {
            $subject = $subject->getIterator()->current();
        }
        return in_array($attribute, VoterAttribute::getAttributes()) && $subject instanceof Tag;
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

        return isset($permissions[Tag::class]) ? $permissions[Tag::class]->{$attribute} ?? false : false;
    }
}
