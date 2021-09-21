<?php

namespace App\Controller\ArticleController;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Config;
use App\DataMapper\ArticleMapper;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Trait\PaginatorTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetPopularArticles extends AbstractController
{
    use PaginatorTrait;

    public function __construct(private ArticleMapper $articleMapper) {}

    public function __invoke(Request $request) : Paginator
    {
        $gameSlug = $request->query->get('game_slug');
        [$page, $pageSize] = $this->getPaginatorArgs($request);

        /**  @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        return $repository->getPopularArticles($gameSlug, $page, $pageSize);
    }
}
