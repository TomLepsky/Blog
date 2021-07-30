<?php

namespace App\Repository;

use App\Entity\GameTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameTranslation[]    findAll()
 * @method GameTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameTranslation::class);
    }

    // /**
    //  * @return GameTranslation[] Returns an array of GameTranslation objects
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
    public function findOneBySomeField($value): ?GameTranslation
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
