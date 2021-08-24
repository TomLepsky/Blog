<?php

namespace App\Serializer\Normalizer;

use App\Entity\Game;
use App\Repository\ArticleRepository;
use ArrayObject;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class GameNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'GAME_NORMALIZER_ALREADY_CALLED';

    public function __construct(private ArticleRepository $articleRepository)
    {
    }

    public function supportsNormalization($data, string $format = null, array $context = []) : bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Game;
    }

    public function normalize($object, string $format = null, array $context = []) : array|string|int|float|bool|ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;
        $object->setArticlesCount($this->articleRepository->getQuantity($object->getId()));
        return $this->normalizer->normalize($object, $format, $context);
    }
}
