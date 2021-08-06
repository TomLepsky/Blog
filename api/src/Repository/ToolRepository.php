<?php

namespace App\Repository;

use App\Entity\Locale;
use App\Entity\Tool;
use App\Entity\ToolTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tool|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tool|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tool[]    findAll()
 * @method Tool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tool::class);
    }

    private function prepareTranslatable($localeName) : QueryBuilder
    {
        return $this->createQueryBuilder('translatable')
            ->select('translatable.id, translation.name, locale.name as locale_name, IDENTITY(translatable.media) AS mediaId, translatable.href, IDENTITY(translatable.game) AS gameId')
            ->innerJoin(ToolTranslation::class, 'translation', 'WITH', 'translatable.id = translation.tool')
            ->innerJoin(Locale::class, 'locale', 'WITH', 'translation.locale = locale.id')
            ->where('locale.name = :locale_name')
            ->setParameter('locale_name', $localeName);
    }

    public function getTranslatableCollection(string $localeName)
    {
        return $this->prepareTranslatable($localeName)
            ->getQuery()
            ->getResult();
    }

    public function getTranslatableItem(int $id, string $localeName)
    {
        return $this->prepareTranslatable($localeName)
            ->andWhere('translatable.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Tool[] Returns an array of Tool objects
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
    public function findOneBySomeField($value): ?Tool
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
