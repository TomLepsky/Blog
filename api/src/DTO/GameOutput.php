<?php

namespace App\DTO;

use App\Entity\MediaObject;
use App\Embeddable\MetaInformation;
use Symfony\Component\Serializer\Annotation\Groups;

class GameOutput
{
    /**
     * @Groups({"gameItem:read", "gameCollection:read", "articleItem:read", "articleCollection:read"})
     */
    public int $id;

    /**
     * @Groups({"gameItem:read", "gameCollection:read", "articleItem:read", "articleCollection:read"})
     */
    public string $name;

    /**
     * @Groups({"gameItem:read", "gameCollection:read", "articleItem:read", "articleCollection:read"})
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
