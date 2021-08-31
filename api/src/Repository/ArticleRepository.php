<?php

namespace App\Repository;

use App\Entity\Article;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public const PREVIOUS = 1;

    public const NEXT = 2;

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

    /**
     * @param DateTimeInterface $date
     * @param int $type
     * @return ?Article
     */
    public function getBoundArticle(DateTimeInterface $date, int $type = self::PREVIOUS) : ?Article
    {
        $bird = '<';
        $order = 'DESC';

        if ($type === self::NEXT) {
            $bird = '>';
            $order = 'ASC';
        }

        $result = $this->createQueryBuilder('a')
            ->where("a.createdAt {$bird} :date")
            ->setParameter('date', $date)
            ->orderBy('a.createdAt', $order)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return !empty($result) ? $result[0] : null;
    }
}
