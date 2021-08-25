<?php

namespace App\DTO;

use App\Entity\Game;
use App\Entity\MediaObject;
use App\Entity\MetaInformation;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

class ArticleOutput
{
    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public int $id;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public string $header;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public string $content;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public string $slug;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public ?Collection $tags;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public ?MediaObject $previewImage;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public ?MediaObject $detailImage;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public ?Collection $children;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public ?Game $game;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public int $timeToRead;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public ?DateTimeInterface $createdAt;

    /**
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    public ?DateTimeInterface $updatedAt;

    public ?MetaInformation $meta;
}
