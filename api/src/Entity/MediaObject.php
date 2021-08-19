<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MediaLibraryRepository;
use App\Security\Voter\VoterAttribute;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MediaObjectRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
//            "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
//            "security" => "is_granted('" . VoterAttribute::EDIT . "', object)"
        ],
        'delete' => [
//            "security" => "is_granted('" . VoterAttribute::DELETE . "', object)"
        ]
    ],
    denormalizationContext: [
        'groups' => ['mediaLibrary:write']
    ],
    normalizationContext: [
        'groups' => ['mediaLibrary:read']
    ],
)]
class MediaObject
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

    public function __construct()
    {
        $this->tools = new ArrayCollection();
    }
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
