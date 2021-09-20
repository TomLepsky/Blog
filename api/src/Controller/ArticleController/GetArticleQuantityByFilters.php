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
class GetArticleQuantityByFilters extends AbstractController
{
    /**
     * @param Request $request
     * @return Collection<string, int>
     */
    public function __invoke(Request $request) : Collection
    {
        $queryParameters = $request->query->all();
        foreach (array_keys($queryParameters) as $queryKey) {
            if (!in_array($queryKey, ArticleRepository::VALID_FILTER_PARAMETERS)) {
                unset($queryParameters[$queryKey]);
            }
        }

        /** @var ArticleRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Article::class);

        return new ArrayCollection([
            "total" => empty($queryParameters) ? 0 : $repository->getQuantityByFilters($queryParameters)
        ]);
    }
}
