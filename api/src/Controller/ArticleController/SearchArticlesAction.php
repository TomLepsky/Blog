<?php

namespace App\Controller\ArticleController;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Config;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SearchArticlesAction extends AbstractController
{
    public function __invoke(Request $request) : Paginator
    {
        $page = (int) $request->query->get('page', Config::DEFAULT_FIRST_PAGE);
        $pageSize = (int) $request->query->get('pageSize', Config::DEFAULT_PAGE_SIZE);
        $pageSize = $pageSize > Config::MAX_PAGE_SIZE ? Config::MAX_PAGE_SIZE : $pageSize;
        $queryParameters = $request->query->all();
        foreach (array_keys($queryParameters) as $queryKey) {
            if (!in_array($queryKey, ArticleRepository::VALID_QUERY_PARAMETERS)) {
                unset($queryParameters[$queryKey]);
            }
        }

        /** @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);
        return $repository->search($queryParameters, $page, $pageSize);
    }
}
