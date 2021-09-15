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
     * @Groups({"articleItem:read"})
     */
    public int $id;

    /**
     * @Groups({"articleItem:read"})
     */
    public string $header;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?string $content;

    /**
     * @Groups({"articleItem:read"})
     */
    public string $slug;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?Collection $tags = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?MediaObject $previewImage = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?MediaObject $detailImage = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?Game $game = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public int $timeToRead;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?DateTimeInterface $createdAt;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?string $mappedCreatedAt = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?MetaInformation $meta = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?ArticleBoundOutput $previousArticle = null;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?ArticleBoundOutput $nextArticle = null;
}
