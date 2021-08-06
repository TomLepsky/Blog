<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\ToolOutput;
use App\Entity\Tool;

class ToolOutputDataTransformer implements DataTransformerInterface
{

    public function transform($object, string $to, array $context = []) : ToolOutput
    {
        $tag = new ToolOutput();
        $tag->id = $object['id'];
        $tag->name = $object['name'];
        $tag->locale = $object['locale_name'];
        $tag->media = $object['media'];
        $tag->gameId = $object['gameId'] ?? null;
        $tag->href = $object['href'];

        return $tag;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ToolOutput::class === $to && ($data instanceof Tool || $context['resource_class'] === Tool::class);
    }
}
