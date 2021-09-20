<?php

namespace App\Controller\ArticleController;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Config;
use App\DataMapper\ArticleMapper;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetPopularArticles extends AbstractController
{
    public function __construct(private ArticleMapper $articleMapper) {}

    public function __invoke(Request $request) : Paginator
    {
        $gameSlug = $request->query->get('game_slug');
        $page = (int) $request->query->get('page', Config::DEFAULT_FIRST_PAGE);
        $pageSize = (int) $request->query->get('pageSize', Config::DEFAULT_PAGE_SIZE);
        $pageSize = $pageSize > Config::MAX_PAGE_SIZE ? Config::MAX_PAGE_SIZE : $pageSize;

        /**  @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        return $repository->getPopularArticles($gameSlug, $page, $pageSize);
    }
}
