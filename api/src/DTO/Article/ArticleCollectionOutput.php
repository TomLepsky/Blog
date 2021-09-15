<?php

namespace App\DTO\Article;

use App\Entity\Game;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ArticleCollectionOutput
{
    /**
     * @Groups({"articleCollection:read"})
     */
    public int $id;

    /**
     * @Groups({"articleCollection:read"})
     */
    public string $header;

    /**
     * @Groups({"articleCollection:read"})
     */
    public string $slug;

    /**
     * @Groups({"articleCollection:read"})
     */
    public ?Game $game = null;

    /**
     * @Groups({"articleCollection:read"})
     */
    public int $timeToRead;

    /**
     * @Groups({"articleCollection:read"})
     */
    public ?DateTimeInterface $createdAt = null;

    /**
     * @Groups({"articleCollection:read"})
     */
    public ?string $formattedCreatedAt = null;
}
