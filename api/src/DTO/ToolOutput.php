<?php

namespace App\DTO;

use App\Entity\MediaLibrary;
use Symfony\Component\Serializer\Annotation\Groups;

class ToolOutput
{
    #[Groups(["toolCollection:read", "toolItem:read"])]
    public int $id;

    #[Groups(["toolCollection:read", "toolItem:read"])]
    public string $name;

    #[Groups(["toolCollection:read", "toolItem:read"])]
    public string $locale;

    #[Groups(["toolCollection:read", "toolItem:read"])]
    public ?MediaLibrary $media;

    #[Groups(["toolCollection:read", "toolItem:read"])]
    public ?int $gameId;

    #[Groups(["toolCollection:read", "toolItem:read"])]
    public ?string $href;
}
