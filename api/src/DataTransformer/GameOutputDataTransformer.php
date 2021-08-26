<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\GameOutput;
use App\Entity\Game;
use App\Embeddable\MetaInformation;
use App\Repository\ArticleRepository;

class GameOutputDataTransformer implements DataTransformerInterface
{
    public function __construct(private ArticleRepository $articleRepository){}

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
        $gameOutput->articlesCount = $this->articleRepository->getQuantity($object->getId());
        $gameOutput->image = $object->getImage();
print_r("Game transformer");exit();
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
