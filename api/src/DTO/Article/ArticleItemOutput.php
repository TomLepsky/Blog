<?php

namespace App\DTO\Article;

use App\Entity\Game;
use App\Entity\MediaObject;
use App\Embeddable\MetaInformation;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

class ArticleItemOutput
{
    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public int $id;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public string $header;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?string $content;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public string $slug;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?Collection $tags = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?MediaObject $previewImage = null;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?MediaObject $detailImage = null;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?Game $game = null;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public int $timeToRead;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?DateTimeInterface $createdAt;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?string $mappedCreatedAt = null;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?MetaInformation $seo = null;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?ArticleBoundOutput $previousArticle = null;

    /**
     * @Groups({"articleItem:read", "article:write"})
     */
    public ?ArticleBoundOutput $nextArticle = null;
}
