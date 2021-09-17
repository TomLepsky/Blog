<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DataMapper\MetaInformationMapper;
use App\DTO\GameOutput;
use App\Entity\Game;
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

        if ($object->getTitle() !== null ||
            $object->getDescription() !== null ||
            $object->getOgTitle() !== null ||
            $object->getOgDescription() !== null) {

            $gameOutput->meta = MetaInformationMapper::setMetaInformationFromEntity($object);
        }

        return $gameOutput;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return GameOutput::class === $to && $data instanceof Game;
    }
}
