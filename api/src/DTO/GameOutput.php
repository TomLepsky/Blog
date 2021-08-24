<?php

namespace App\DTO;

use App\Entity\MediaObject;
use App\Entity\MetaInformation;
use Symfony\Component\Serializer\Annotation\Groups;

class GameOutput
{
    /**
     * @Groups({"gameItem:read", "gameCollection:read"})
     */
    public int $id;

    /**
     * @Groups({"gameItem:read", "gameCollection:read"})
     */
    public string $name;

    /**
     * @Groups({"gameItem:read", "gameCollection:read"})
     */
    public string $slug;

    /**
     * @Groups({"gameItem:read", "gameCollection:read"})
     */
    public int $articlesCount;

    /**
     * @Groups({"gameItem:read", "gameCollection:read"})
     */
    public ?MediaObject $image = null;

    /**
     * @Groups({"gameItem:read"})
     */
    public ?MetaInformation $meta;
}