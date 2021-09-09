<?php

namespace App\Repository\Auth;

use App\Entity\Auth\GamePermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GamePermission|null find($id, $lockMode = null, $lockVersion = null)
 * @method GamePermission|null findOneBy(array $criteria, array $orderBy = null)
 * @method GamePermission[]    findAll()
 * @method GamePermission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamePermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GamePermission::class);
    }

    // /**
    //  * @return GameAttributes[] Returns an array of GameAttributes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameAttributes
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
