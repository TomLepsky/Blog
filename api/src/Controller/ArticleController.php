<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\DataTransformer\ArticleOutputDataTransformer;
use App\DTO\ArticleOutput;
use App\DTO\ToolOutput;
use App\Entity\Article;
use App\Entity\Locale;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getTranslatableCollection(Request $request) : Collection
    {
        $locale = $request->headers->get('X-LOCALE', 'en');
        if (!$this->entityManager->getRepository(Locale::class)->isExist($locale)) {
            throw new ValidationException("There is no such locale: {$locale}");
        }

        $result = $this->entityManager->getRepository(Article::class)->getTranslatableCollection($locale);

        if (empty($result)) {
            throw new NotFoundHttpException("There is no tools with such locale: \"{$locale}\"");
        }

        $context['resource_class'] = Article::class;
        $dataTransformer = new ArticleOutputDataTransformer();
        $output = new ArrayCollection();
        foreach ($result as $entity) {
            if ($dataTransformer->supportsTransformation($entity, ArticleOutput::class, $context)) {
                $output->add($dataTransformer->transform($entity, ArticleOutput::class, $context));
            }
        }
        return $output;
    }

    public function getTranslatableItem(string $id, Request $request) : ?ArticleOutput
    {
        $locale = $request->headers->get('X-LOCALE', 'en');
        if (!$this->entityManager->getRepository(Locale::class)->isExist($locale)) {
            throw new ValidationException("There is no such locale: {$locale}");
        }

        $result = $this->entityManager->getRepository(Article::class)->getTranslatableItem(intval($id), $locale);
        if (empty($result)) {
            throw new NotFoundHttpException("There is no tool with such id: \"{$id}\" and locale: \"{$locale}\"");
        }

        $context['resource_class'] = Article::class;
        $result = $result[0];
        $dataTransformer = new ArticleOutputDataTransformer();
        $output = null;
        if ($dataTransformer->supportsTransformation($result, ArticleOutput::class, $context)) {
            $output = $dataTransformer->transform($result, ArticleOutput::class, $context);
        }

        return $output;
    }
}
