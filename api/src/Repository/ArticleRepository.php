<?php

namespace App\Repository;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Entity\Article;
use App\Entity\Game;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
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

    public const TAGS_SLUG = 'tags_slug';
    public const GAME_SLUG = 'game_slug';
    public const HEADER = 'header';

    public const MAX_RELATED = 7;

    public const VALID_QUERY_PARAMETERS = [
        self::TAGS_SLUG,
        self::GAME_SLUG,
        self::HEADER
    ];

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
     * @param string|null $game
     * @return Article[]
     */
    public function getPopularArticles(?string $game = null) : array
    {
        $queryBuilder = $this->createQueryBuilder('a');
        if ($game !== null) {
            $queryBuilder
                ->innerJoin(Game::class, 'g', 'WITH', 'a.game = g.id')
                ->andWhere('g.slug = :slug')
                ->setParameter('slug', $game);
        }
        $queryBuilder->andWhere('a.popular IS NOT NULL');

        return $queryBuilder->getQuery()->getResult();
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

    /**
     * @param array $parameters
     * @param int $page
     * @param int $pageSize
     * @return Paginator
     */
    public function search(array $parameters = [], int $page = 1, int $pageSize = 15) : Paginator
    {
        $query = "
            SELECT a FROM App\Entity\Article a
                JOIN a.tags t
                JOIN a.game g
        ";

        $bindParameters = [];
        if (!empty($parameters)) {
            $whereClause = [];
            foreach ($parameters as $key => $value) {
                switch ($key) {
                    case self::TAGS_SLUG:
                        if (!is_array($value)) {
                            $value = [$value];
                        }

                        $nestedWhereClause = [];
                        $count = count($value);
                        for ($i = 0; $i < $count; $i++) {
                            $bind = "tag_slug_{$i}";
                            $nestedWhereClause[] = "t2.slug = :{$bind}";
                            $bindParameters[$bind] = $value[$i];
                        }

                        $clause = implode(" OR ", $nestedWhereClause);
                        $whereClause[self::TAGS_SLUG] = "
                            a.id IN (SELECT a2.id FROM App\Entity\Article a2
                                    JOIN a2.tags t2
                                WHERE {$clause}
                                GROUP BY a2.id
                                HAVING count(a2.id) = {$count})
                        ";
                        break;

                    case self::GAME_SLUG:
                        $bind = "game_slug";
                        $whereClause[self::GAME_SLUG] = "g.slug = :{$bind}";
                        $bindParameters[$bind] = $value;
                        break;

                    case self::HEADER:
                        if (strlen($value) < 4) {
                            break;
                        }
                        $bind = "header";
                        $whereClause[self::HEADER] = "a.header LIKE :{$bind}";
                        $bindParameters[$bind] = "%{$value}%";
                        break;
                }
            }

            $whereClause = implode(" AND ", $whereClause);
            $query .= "WHERE {$whereClause}";
        }

        $firstResult = ($page - 1) * $pageSize;
        return new Paginator(
            new DoctrinePaginator(
                $this->getEntityManager()
                    ->createQuery($query)
                    ->setParameters($bindParameters)
                    ->setFirstResult($firstResult)
                    ->setMaxResults($pageSize)
            )
        );
    }

    public function getArticleItem(string $articleSlug, ?string $gameSlug = null) : ?Article
    {
        $queryBuilder = $this->createQueryBuilder('a');
        if ($gameSlug !== null) {
            $queryBuilder
                ->innerJoin(Game::class, 'g', 'WITH', 'a.game = g.id')
                ->andWhere('g.slug = :gameSlug')
                ->setParameter('gameSlug', $gameSlug);
        }
        $queryBuilder
            ->andWhere('a.slug = :articleSlug')
            ->setParameter('articleSlug', $articleSlug);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
