<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\DTO\ArticleTranslationInput;
use App\Entity\Article;
use App\Entity\ArticleTranslation;
use App\Entity\Locale;
use DateTime;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;

class ArticleTranslationInputDataTransformer implements DataTransformerInterface
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function transform($object, string $to, array $context = []) : ArticleTranslation
    {
        if (isset($context[AbstractItemNormalizer::OBJECT_TO_POPULATE])) {
            $articleTranslation = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        } else {
            $this->validator->validate($object);
            $articleTranslation = new ArticleTranslation();
        }

        if (isset($object->header)) {
            $articleTranslation->setHeader($object->header);
        }
        if (isset($object->content)) {
            $articleTranslation->setContent($object->content);
        }
        if (isset($object->article)) {
            preg_match_all("/(\d+)$/", $object->article, $articleId);
            $article = $this->entityManager->getRepository(Article::class)->find($articleId[0][0]);
            $articleTranslation->setArticle($article);
        }
        if (isset($object->locale)) {
            preg_match_all("/(\d+)$/", $object->locale, $localeId);
            $locale = $this->entityManager->getRepository(Locale::class)->find($localeId[0][0]);
            $articleTranslation->setLocale($locale);
        }
        $articleTranslation->setUpdateAt((new DateTime("now")));
        $articleTranslation->setSecondsForReading((int) count(explode(" ", $articleTranslation->getContent())) * 0.3);

        return $articleTranslation;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return $to === ArticleTranslation::class && ($context['input']['class'] ?? null) === ArticleTranslationInput::class;
    }
}
