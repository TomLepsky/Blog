<?php

namespace App\Controller\ArticleController;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Config;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Trait\PaginatorTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SearchArticlesAction extends AbstractController
{
    use PaginatorTrait;

    /**
     * @param Request $request
     * @return Paginator
     */
    public function __invoke(Request $request) : Paginator
    {
        [$page, $pageSize] = $this->getPaginatorArgs($request);
        $queryParameters = $request->query->all();
        foreach (array_keys($queryParameters) as $queryKey) {
            if (!in_array($queryKey, ArticleRepository::VALID_FILTER_PARAMETERS)) {
                unset($queryParameters[$queryKey]);
            }
        }

        /** @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        return $repository->search($queryParameters, $page, $pageSize);
    }
}
