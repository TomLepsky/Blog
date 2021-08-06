<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\ArticleTranslation;
use App\Entity\Locale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    private function prepareTranslatable($localeName) : QueryBuilder
    {
        return $this->createQueryBuilder('translatable')
            ->select('translatable.id, translation.header, translation.content, locale.name as locale_name, translatable.createdAt, translation.updatedAt, translation.secondsForReading')
            ->innerJoin(ArticleTranslation::class, 'translation', 'WITH', 'translatable.id = translation.article')
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
}
