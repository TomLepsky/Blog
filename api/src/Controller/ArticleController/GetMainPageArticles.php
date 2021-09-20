<?php

namespace App\Controller\ArticleController;

use App\DataMapper\ArticleMapper;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetMainPageArticles extends AbstractController
{
    public function __construct(private ArticleMapper $articleMapper) {}

    public function __invoke(Request $request) : array
    {
        $gameSlug = $request->query->get('game_slug');

        /**  @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        return $this->articleMapper->mapPopular($repository->getMainPageArticles($gameSlug));
    }
}
