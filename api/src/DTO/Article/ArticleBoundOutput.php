<?php

namespace App\DTO\Article;

use App\Entity\MediaObject;
use Symfony\Component\Serializer\Annotation\Groups;

class ArticleBoundOutput
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
    public string $slug;

    /**
     * @Groups({"articleItem:read"})
     */
    public ?MediaObject $previewImage;
}
