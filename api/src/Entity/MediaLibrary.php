<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MediaLibraryRepository;
use Doctrine\ORM\Mapping as ORM;
use EasyRdf\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MediaLibraryRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'put',
        'delete'
    ],
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
     * @Groups({"mediaLibrary:read", "tool:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"mediaLibrary:read", "mediaLibrary:write", "tool:read", "tool:write"})
     * @Assert\NotBlank()
     */
    private $media;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"mediaLibrary:read", "mediaLibrary:write", "tool:read", "tool:write"})
     */
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=Tool::class, mappedBy="media")
     * @Groups({"mediaLibrary:read", "mediaLibrary:write"})
     */
    private ?Collection $tools;

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
