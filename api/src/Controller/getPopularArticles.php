<?php

namespace App\Controller;

use App\DataMapper\ArticleMapper;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class getPopularArticles extends AbstractController
{
    public function __construct(private ArticleMapper $articleMapper) {}

    public function __invoke($data) : array
    {
        /**
         * @var ArticleRepository $articleRepository
         */
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        return $this->articleMapper->mapPopular($articleRepository->getPopularArticles());
    }
}