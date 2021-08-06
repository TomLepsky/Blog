<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Groups;

class TagOutput
{
    #[Groups(["tagCollection:read", "tagItem:read"])]
    public int $id;

    #[Groups(["tagCollection:read", "tagItem:read"])]
    public string $name;

    #[Groups(["tagCollection:read", "tagItem:read"])]
    public string $locale;
}
