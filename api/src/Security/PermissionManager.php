<?php

namespace App\Security;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LogicException;

class PermissionManager
{
    private const REPOSITORY_NAMESPACE = 'App\Repository\Auth\\';
    private const REPOSITORY_SUFFIX = 'PermissionRepository';
    private const DEFAULT_REPOSITORY_NAME = 'Entity';

    public function __construct(private ManagerRegistry $registry) {}

    public function resolve(string $attribute, UserInterface $user, object|string $data) : bool
    {
        if (!is_object($data)) {
            return $this->resolveByDefault($attribute, $user, $this->getShortClassName($data));
        }

        return $this->resolveByEntity($attribute, $user, $data, $this->getShortClassName($data::class));
    }

    public function getPermissionRepository(string $entityClassName) : ServiceEntityRepository
    {
        $entityClassName = $this->getShortClassName($entityClassName);
        $repositoryClassName = self::REPOSITORY_NAMESPACE . $entityClassName . self::REPOSITORY_SUFFIX;
        if (!class_exists($repositoryClassName)) {
            throw new LogicException("Cannot find repository {$repositoryClassName}.");
        }

        return new $repositoryClassName($this->registry);
    }

    private function resolveByEntity(string $attribute, UserInterface $user, object $object, string $entityClassName) : bool
    {
        return $this->doResolve($attribute, $entityClassName, ['entity' => $object->getId(), 'user' =>$user->getId()]);
    }

    private function resolveByDefault(string $attribute, UserInterface $user, string $entityClassName) : bool
    {
        return $this->doResolve($attribute, self::DEFAULT_REPOSITORY_NAME, ['name' => $entityClassName, 'user' =>$user->getId()]);
    }

    private function doResolve(string $attribute,string $entityClassName, array $criteria) : bool
    {
        $permission = $this->getPermissionRepository($entityClassName)->findOneBy($criteria);

        if (is_null($permission)) {
            return false;
        }

        if (!property_exists($permission, $attribute)) {
            throw new LogicException("Invalid voter attribute");
        }

        return $permission->{$attribute};
    }

    private function getShortClassName(string $className) : string
    {
        preg_match('/[\w]+$/', $className, $shortName);
        if (empty($shortName)) {
            throw new LogicException("No class name provided");
        }
        return $shortName[0];
    }
}
