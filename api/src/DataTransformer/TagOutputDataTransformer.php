<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\TagOutput;
use App\Embeddable\MetaInformation;
use App\Entity\Tag;

class TagOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param Tag $object
     * @param string $to
     * @param array $context
     * @return TagOutput
     */
    public function transform($object, string $to, array $context = []) : TagOutput
    {
        $tagOutput = new TagOutput();
        $tagOutput->id = $object->getId();
        $tagOutput->name = $object->getName();
        $tagOutput->slug = $object->getSlug();
        $tagOutput->articlesQuantity = $object->getArticlesQuantity();
        $tagOutput->game = $object->getGame();

        if ($object->getTitle() !== null ||
            $object->getDescription() !== null ||
            $object->getOgTitle() !== null ||
            $object->getOgDescription() !== null) {

            $tagOutput->meta = $this->setMetaInformation($object);
        }

        return $tagOutput;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return TagOutput::class === $to && $data instanceof Tag;
    }

    private function setMetaInformation(Tag $object) : MetaInformation
    {
        $meta = new MetaInformation();
        $meta->setTitle($object->getTitle());
        $meta->setDescription($object->getDescription());
        $meta->setOgTitle($object->getOgTitle());
        $meta->setOgDescription($object->getOgDescription());
        $meta->setKeyWords($object->getKeyWords());
        return $meta;
    }
}
