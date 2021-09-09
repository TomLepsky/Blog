<?php

namespace App\DataTransformer\Article;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DataMapper\DateMapper;
use App\DTO\Article\ArticleCollectionOutput;
use App\Entity\Article;

class ArticleCollectionOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param Article $object
     * @param string $to
     * @param array $context
     * @return ArticleCollectionOutput
     */
    public function transform($object, string $to, array $context = []) : ArticleCollectionOutput
    {
        $articleOutput = new ArticleCollectionOutput();
        $articleOutput->id = $object->getId();
        $articleOutput->header = $object->getHeader();
        $articleOutput->slug = $object->getSlug();
        $articleOutput->game = $object->getGame();
        $articleOutput->timeToRead = $object->getTimeToRead();
        $articleOutput->createdAt = $object->getCreatedAt();
        $articleOutput->formattedCreatedAt = DateMapper::mapArticlePublishDate($object->getCreatedAt());

        return $articleOutput;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ArticleCollectionOutput::class === $to && $data instanceof Article;
    }
}
