<?php

namespace App\Controller\ArticleController;

use App\DataMapper\ArticleMapper;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetPopularArticles extends AbstractController
{
    public function __construct(private ArticleMapper $articleMapper) {}

    public function __invoke(Request $request) : array
    {
        $gameSlug = $request->query->get('game_slug', null);

        /**  @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        return $this->articleMapper->mapPopular($repository->getPopularArticles($gameSlug));
    }
}
