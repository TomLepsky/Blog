<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\GameOutput;
use App\DTO\MediaObjectOutput;
use App\Entity\Game;
use App\Entity\MetaInformation;

class GameOutputDataTransformer implements DataTransformerInterface
{
    /**
     * @param Game $object
     * @param string $to
     * @param array $context
     * @return GameOutput
     */
    public function transform($object, string $to, array $context = []) : GameOutput
    {
        $gameOutput = new GameOutput();
        $gameOutput->id = $object->getId();
        $gameOutput->name = $object->getName();
        $gameOutput->slug = $object->getSlug();
        $gameOutput->articlesCount = $object->getArticlesCount();
        $gameOutput->image = $object->getImage();

        $meta = new MetaInformation();
        $meta->setTitle($object->getTitle());
        $meta->setDescription($object->getDescription());
        $meta->setOgTitle($object->getOgTitle());
        $meta->setOgDescription($object->getOgDescription());
        $meta->setKeyWords($object->getKeyWords());
        $gameOutput->meta = $meta;

        return $gameOutput;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return GameOutput::class === $to && $data instanceof Game;
    }
}