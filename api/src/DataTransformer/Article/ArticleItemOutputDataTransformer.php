<?php

namespace App\DataTransformer\Article;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\DataMapper\DateMapper;
use App\DataMapper\MetaInformationMapper;
use App\DTO\Article\ArticleBoundOutput;
use App\DTO\Article\ArticleItemOutput;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class ArticleItemOutputDataTransformer implements DataTransformerInterface
{
    public function __construct(private ArticleRepository $repository) {}

    /**
     * @param Article $object
     * @param string $to
     * @param array $context
     * @return ArticleItemOutput
     */
    public function transform($object, string $to, array $context = []) : ArticleItemOutput
    {
        $articleOutput = new ArticleItemOutput();
        $articleOutput->id = $object->getId();
        $articleOutput->header = $object->getHeader();
        $articleOutput->content = $object->getContent();
        $articleOutput->slug = $object->getSlug();
        $articleOutput->previewImage = $object->getPreviewImage();
        $articleOutput->detailImage = $object->getDetailImage();
        $articleOutput->tags = $object->getTags();
        $articleOutput->game = $object->getGame();
        $articleOutput->timeToRead = $object->getTimeToRead();

        if ($object->getTitle() !== null ||
            $object->getDescription() !== null ||
            $object->getOgTitle() !== null ||
            $object->getOgDescription() !== null) {

            $articleOutput->seo = MetaInformationMapper::setMetaInformationFromEntity($object);
        }

        $articleOutput->createdAt = $object->getCreatedAt();
        $articleOutput->mappedCreatedAt = DateMapper::mapArticlePublishDate($object->getCreatedAt());

        if (($previous = $this->repository->getBoundArticle($object->getCreatedAt(), ArticleRepository::PREVIOUS)) !== null) {
            $articleOutput->previousArticle = $this->setBoundArticle($previous);
        }

        if (($next = $this->repository->getBoundArticle($object->getCreatedAt(), ArticleRepository::NEXT)) !== null) {
            $articleOutput->nextArticle = $this->setBoundArticle($next);
        }

        return $articleOutput;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ArticleItemOutput::class === $to && $data instanceof Article;
    }

    private function setBoundArticle(Article $article) : ArticleBoundOutput
    {
        $boundArticle = new ArticleBoundOutput();
        $boundArticle->id = $article->getId();
        $boundArticle->slug = $article->getSlug();
        $boundArticle->header = $article->getHeader();
        $boundArticle->timeToRead = $article->getTimeToRead();
        $boundArticle->createdAt = $article->getCreatedAt();
        $boundArticle->mappedCreatedAt = DateMapper::mapArticlePublishDate($article->getCreatedAt());
        $boundArticle->previewImage = $article->getPreviewImage();

        return $boundArticle;
    }
}
