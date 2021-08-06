<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use App\DataTransformer\TagOutputDataTransformer;
use App\DataTransformer\ToolOutputDataTransformer;
use App\DTO\TagOutput;
use App\DTO\ToolOutput;
use App\Entity\Locale;
use App\Entity\MediaLibrary;
use App\Entity\Tag;
use App\Entity\Tool;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ToolController
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

        $result = $this->entityManager->getRepository(Tool::class)->getTranslatableCollection($locale);

        if (empty($result)) {
            throw new NotFoundHttpException("There is no tools with such locale: \"{$locale}\"");
        }

        $mediaRepository = $this->entityManager->getRepository(MediaLibrary::class);
        $context['resource_class'] = Tool::class;
        $dataTransformer = new ToolOutputDataTransformer();
        $output = new ArrayCollection();
        foreach ($result as $entity) {
            if ($dataTransformer->supportsTransformation($entity, ToolOutput::class, $context)) {
                $entity['media'] = $mediaRepository->findOneBy(['id' => $entity['mediaId']]);
                $output->add($dataTransformer->transform($entity, ToolOutput::class, $context));
            }
        }
        return $output;
    }

    public function getTranslatableItem(string $id, Request $request) : ToolOutput
    {
        $locale = $request->headers->get('X-LOCALE', 'en');
        if (!$this->entityManager->getRepository(Locale::class)->isExist($locale)) {
            throw new ValidationException("There is no such locale: {$locale}");
        }

        $result = $this->entityManager->getRepository(Tool::class)->getTranslatableItem(intval($id), $locale);
        if (empty($result)) {
            throw new NotFoundHttpException("There is no tool with such id: \"{$id}\" and locale: \"{$locale}\"");
        }

        $mediaRepository = $this->entityManager->getRepository(MediaLibrary::class);
        $context['resource_class'] = Tool::class;
        $result = $result[0];
        $dataTransformer = new ToolOutputDataTransformer();
        $output = null;
        if ($dataTransformer->supportsTransformation($result, ToolOutput::class, $context)) {
            $result['media'] = $mediaRepository->findOneBy(['id' => $result['mediaId']]);
            $output = $dataTransformer->transform($result, ToolOutput::class, $context);
        }

        return $output;
    }

}
