<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, VoterAttribute::getAttributes()) && $subject instanceof Article;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (null === $user || (!$user instanceof UserInterface)) {
            throw new AuthenticationException('Authentication failed!');
        }

        $permissions = $user->getPermissions();
        return isset($permissions[Article::class]) ? $permissions[Article::class]->{$attribute} ?? false : false;
    }
}
