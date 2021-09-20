<?php

namespace App\Controller\ArticleController;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetRelatedArticles extends AbstractController
{

    public function __invoke(Request $request) : Collection
    {
        $articleSlug = $request->query->get('article_slug');
        $gameSlug = $request->query->get('game_slug');

        if ($articleSlug === null) {
            return new ArrayCollection();
        }

        $criteria = ['slug' => $articleSlug];

        /** @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);

        /** @var Article $article */
        $article = $repository->findOneBy($criteria);

        return $article->getChildren();
    }
}
