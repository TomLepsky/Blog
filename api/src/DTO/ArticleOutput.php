<?php

namespace App\DTO;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\Collection;
use EasyRdf\Literal\Date;
use Symfony\Component\Serializer\Annotation\Groups;

class ArticleOutput
{
    #[Groups(["articleCollection:read"])]
    public int $id;

    #[Groups(["articleCollection:read"])]
    public string $header;

    #[Groups(["articleCollection:read"])]
    public string $content;

    #[Groups(["articleCollection:read"])]
    public string $locale;

    #[Groups(["articleCollection:read"])]
    public ?\DateTime $createdAt;

    #[Groups(["articleCollection:read"])]
    public ?\DateTime $updatedAt;

    #[Groups(["articleCollection:read"])]
    public ?int $secondsForReading;

    #[Groups(["articleCollection:read"])]
    public ?Collection $tags;

    #[Groups(["articleCollection:read"])]
    public ?Collection $parents;

    #[Groups(["articleCollection:read"])]
    public ?Collection $children;
}
