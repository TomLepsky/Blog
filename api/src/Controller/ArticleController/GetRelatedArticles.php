<?php

namespace App\Controller\ArticleController;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Trait\PaginatorTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class GetRelatedArticles extends AbstractController
{
    use PaginatorTrait;

    public function __invoke(Request $request) : Paginator
    {
        $articleSlug = $request->query->get('article_slug');
        $gameSlug = $request->query->get('game_slug');
        if ($articleSlug === null) {
            throw new BadRequestException("Please, provide article slug.");
        }

        /** @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->getArticleItem($articleSlug, $gameSlug);

        if ($article === null) {
            throw new NotFoundHttpException("Not Found article with slug: {$articleSlug}");
        }
        [$page, $pageSize] = $this->getPaginatorArgs($request);

        return $repository->getChildrenOf($article, $page, $pageSize);
    }
}
