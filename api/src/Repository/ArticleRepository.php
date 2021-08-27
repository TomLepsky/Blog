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

    public function getQuantity(string $gameId) : int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.game = :gameId')
            ->setParameter('gameId', $gameId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Article[]
     */
    public function getPopularArticles() : array
    {
        return $this->createQueryBuilder('a')
            ->where('a.popular IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}
