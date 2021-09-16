<?php

namespace App\Serializer\Normalizer;


use App\Entity\MediaObject;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

class MediaObjectNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(private StorageInterface $storage) {}

    public function supportsNormalization($data, string $format = null, array $context = []) : bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof MediaObject;
    }

    public function normalize($object, string $format = null, array $context = []) : array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        $storageHost = getenv('REMOTE_MEDIA_OBJECT_STORAGE_HOST') ?? "https://{$_SERVER['SERVER_NAME']}";
        $object->setOriginal("$storageHost{$this->storage->resolveUri($object, 'file')}");

        return $this->normalizer->normalize($object, $format, $context);
    }
}
