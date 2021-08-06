<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DTO\ArticleOutput;
use App\Entity\Article;

class ArticleOutputDataTransformer implements DataTransformerInterface
{

    public function transform($object, string $to, array $context = []) : ArticleOutput
    {
        $articleOutput = new ArticleOutput();
        $articleOutput->id = $object['id'];
        $articleOutput->header = $object['header'];
        $articleOutput->content = $object['content'];
        $articleOutput->createdAt = $object['createdAt'];
        $articleOutput->updatedAt = $object['updatedAt'];
        $articleOutput->locale = $object['locale_name'];
        $articleOutput->secondsForReading = $object['secondsForReading'];
        $articleOutput->children = $object['children'] ?? null;
        $articleOutput->parents = $object['parents'] ?? null;
        $articleOutput->tags = $object['tags'] ?? null;

        return $articleOutput;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ArticleOutput::class === $to && ($data instanceof Article || $context['resource_class'] === Article::class);
    }
}
