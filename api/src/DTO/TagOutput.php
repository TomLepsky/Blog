<?php

namespace App\DTO;

use App\Entity\Game;
use App\Embeddable\MetaInformation;
use Symfony\Component\Serializer\Annotation\Groups;

class TagOutput
{
    /**
     * @Groups({"tagItem:read", "tagCollection:read"})
     */
    public ?int $id;

    /**
     * @Groups({"tagItem:read", "tagCollection:read"})
     */
    public ?string $name;

    /**
     * @Groups({"tagItem:read", "tagCollection:read"})
     */
    public ?string $slug;

    /**
     * @Groups({"tagItem:read", "tagCollection:read"})
     */
    public ?int $articlesQuantity = 0;

    /**
     * @Groups({"tagItem:read", "tagCollection:read"})
     */
    public ?Game $game;

    /**
     * @Groups({"tagItem:read"})
     */
    public ?MetaInformation $meta;
}
