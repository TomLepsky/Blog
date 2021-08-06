<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\DataTransformer\TagOutputDataTransformer;
use App\DTO\TagOutput;
use App\Entity\Locale;
use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController
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

        $result = $this->entityManager->getRepository(Tag::class)->getTranslatableCollection($locale);
        $context['resource_class'] = Tag::class;

        $dataTransformer = new TagOutputDataTransformer();
        $output = new ArrayCollection();
        foreach ($result as $entity) {
            if ($dataTransformer->supportsTransformation($entity, TagOutput::class, $context)) {
                $output->add($dataTransformer->transform($entity, TagOutput::class, $context));
            }
        }
        return $output;
    }

    public function getTranslatableItem(string $id, Request $request) : TagOutput
    {
        $locale = $request->headers->get('X-LOCALE', 'en');
        if (!$this->entityManager->getRepository(Locale::class)->isExist($locale)) {
            throw new ValidationException("There is no such locale: {$locale}");
        }

        $result = $this->entityManager->getRepository(Tag::class)->getTranslatableItem(intval($id), $locale);
        if (empty($result)) {
            throw new NotFoundHttpException("There is no tag with such id: \"{$id}\" and locale: \"{$locale}\"");
        }

        $context['resource_class'] = Tag::class;
        $result = $result[0];
        $dataTransformer = new TagOutputDataTransformer();
        $output = null;
        if ($dataTransformer->supportsTransformation($result, TagOutput::class, $context)) {
            $output = $dataTransformer->transform($result, TagOutput::class, $context);
        }

        return $output;
    }
}
