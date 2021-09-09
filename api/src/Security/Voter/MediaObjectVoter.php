<?php

namespace App\Security\Voter;

use App\Entity\MediaObject;
use App\Security\PermissionManager;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class MediaObjectVoter extends Voter
{
    public function __construct(private PermissionManager $manager) {}

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, VoterAttribute::getAttributes()) && $subject instanceof MediaObject;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if ($token instanceof NullToken) {
            throw new AuthenticationException('Please login or provide API token!');
        }

        $user = $token->getUser();
        if (null === $user || (!$user instanceof UserInterface)) {
            throw new AuthenticationException('Authentication failed!');
        }

        return (bool) $this->manager->resolve($attribute, $user, MediaObject::class);
    }
}
