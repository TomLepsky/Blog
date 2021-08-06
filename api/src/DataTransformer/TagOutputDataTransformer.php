<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\TagOutput;
use App\Entity\Tag;

class TagOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []) : TagOutput
    {
        $tag = new TagOutput();
        $tag->id = $object['id'];
        $tag->name = $object['name'];
        $tag->locale = $object['locale_name'];

        return $tag;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return TagOutput::class === $to && ($data instanceof Tag || $context['resource_class'] === Tag::class);
    }
}
