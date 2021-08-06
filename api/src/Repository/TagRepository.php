<?php

namespace App\Repository;

use App\Entity\Locale;
use App\Entity\Tag;
use App\Entity\TagTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function getTranslatableCollection(string $localeName)
    {
        return $this->createQueryBuilder('translatable')
            ->select('translatable.id, translation.name, locale.name as locale_name')
            ->innerJoin(TagTranslation::class, 'translation', 'WITH', 'translatable.id = translation.tag')
            ->innerJoin(Locale::class, 'locale', 'WITH', 'translation.locale = locale.id')
            ->where('locale.name = :locale_name')
            ->setParameter('locale_name', $localeName)
            ->getQuery()
            ->getResult();
    }

    public function getTranslatableItem(int $id, string $localeName)
    {
        return $this->createQueryBuilder('translatable')
            ->select('translatable.id, translation.name, locale.name as locale_name')
            ->innerJoin(TagTranslation::class, 'translation', 'WITH', 'translatable.id = translation.tag')
            ->innerJoin(Locale::class, 'locale', 'WITH', 'translation.locale = locale.id')
            ->where('locale.name = :locale_name')
            ->setParameter('locale_name', $localeName)
            ->andWhere('translatable.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
