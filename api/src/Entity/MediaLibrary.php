<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MediaLibraryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MediaLibraryRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['mediaLibrary:write']
    ],
    normalizationContext: [
        'groups' => ['mediaLibrary:read']
    ],
)]
class MediaLibrary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"mediaLibrary:read", "toolCollection:read", "toolItem:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"mediaLibrary:read", "mediaLibrary:write"})
     */
    private $media;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"mediaLibrary:read", "mediaLibrary:write"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ToolTranslation::class, mappedBy="media")
     * @Groups({"mediaLibrary:read", "mediaLibrary:write"})
     */
    private $tools;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setMedia($media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
