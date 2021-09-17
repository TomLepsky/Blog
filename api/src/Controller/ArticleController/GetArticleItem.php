<?php

namespace App\Controller\ArticleController;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsController]
class GetArticleItem extends AbstractController
{
    public function __invoke(string $gameSlug, string $articleSlug, Request $request) : Article
    {
        /**  @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->getArticleItem($articleSlug, $gameSlug);

        if ($article === null) {
            throw new NotFoundHttpException("Not Found");
        }

        return $article;
    }
}
