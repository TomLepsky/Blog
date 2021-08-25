<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

class MetaInformation
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"gameItem:read", "game:write", "articleItem:read", "article:write", "tagItem:read", "tagCollection:read"})
     */
    protected ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"gameItem:read", "game:write", "articleItem:read", "article:write", "tagItem:read", "tag:write"})
     */
    protected ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"gameItem:read", "game:write", "articleItem:read", "article:write", "tagItem:read", "tag:write"})
     */
    protected ?string $ogTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"gameItem:read", "game:write", "articleItem:read", "article:write", "tagItem:read", "tag:write"})
     */
    protected ?string $ogDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"gameItem:read", "game:write", "articleItem:read", "article:write", "tagItem:read", "tag:write"})
     */
    protected ?string $keyWords;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getOgTitle(): ?string
    {
        return $this->ogTitle;
    }

    public function setOgTitle(?string $ogTitle): void
    {
        $this->ogTitle = $ogTitle;
    }

    public function getOgDescription(): ?string
    {
        return $this->ogDescription;
    }

    public function setOgDescription(?string $ogDescription): void
    {
        $this->ogDescription = $ogDescription;
    }

    public function getKeyWords(): ?string
    {
        return $this->keyWords;
    }

    public function setKeyWords(?string $keyWords): void
    {
        $this->keyWords = $keyWords;
    }

}
