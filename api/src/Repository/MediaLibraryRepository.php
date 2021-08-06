<?php

namespace App\Repository;

use App\Entity\MediaLibrary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MediaLibrary|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaLibrary|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaLibrary[]    findAll()
 * @method MediaLibrary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaLibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaLibrary::class);
    }

    // /**
    //  * @return MediaLibrary[] Returns an array of MediaLibrary objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MediaLibrary
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
