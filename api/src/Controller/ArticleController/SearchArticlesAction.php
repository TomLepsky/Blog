<?php

namespace App\Controller\ArticleController;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SearchArticlesAction extends AbstractController
{
    public function __invoke(Request $request) : array
    {
        $queryParameters = $request->query->all();
        foreach (array_keys($queryParameters) as $queryKey) {
            if (!in_array($queryKey, ArticleRepository::VALID_QUERY_PARAMETERS)) {
                unset($queryParameters[$queryKey]);
            }
        }
        /** @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        return $repository->search($queryParameters);
    }
}
