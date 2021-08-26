<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\ArticleOutput;
use App\Entity\Article;
use App\Embeddable\MetaInformation;

class ArticleOutputDataTransformer implements DataTransformerInterface
{

    /**
     * @param Article $object
     * @param string $to
     * @param array $context
     * @return object|void
     */
    public function transform($object, string $to, array $context = []) : ArticleOutput
    {
        $articleOutput = new ArticleOutput();
        $articleOutput->id = $object->getId();
        $articleOutput->header = $object->getHeader();
        $articleOutput->content = $object->getContent();
        $articleOutput->slug = $object->getSlug();
        $articleOutput->previewImage = $object->getDetailImage();
        $articleOutput->detailImage = $object->getDetailImage();
        $articleOutput->tags = $object->getTags();
        $articleOutput->relative = $object->getChildren();
        $articleOutput->game = $object->getGame();
        $articleOutput->timeToRead = $object->getTimeToRead();

        $meta = new MetaInformation();
        $meta->setTitle($object->getTitle());
        $meta->setDescription($object->getDescription());
        $meta->setOgTitle($object->getOgTitle());
        $meta->setOgDescription($object->getOgDescription());
        $meta->setKeyWords($object->getKeyWords());

        $articleOutput->meta = $meta;
        $articleOutput->createdAt = $object->getCreatedAt();
        $articleOutput->updatedAt = $object->getUpdatedAt();

        return $articleOutput;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ArticleOutput::class === $to && $data instanceof Article;
    }
}
