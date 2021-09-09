<?php

namespace App\Repository\Auth;

use App\Entity\Auth\EntityPermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EntityPermission|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityPermission|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityPermission[]    findAll()
 * @method EntityPermission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityPermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityPermission::class);
    }

    // /**
    //  * @return EntityPermission[] Returns an array of EntityPermission objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EntityPermission
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
