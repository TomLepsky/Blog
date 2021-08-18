<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ToolRepository;
use App\Security\Voter\VoterAttribute;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ToolRepository::class)
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
        'groups' => ['tool:write']
    ],
    normalizationContext: [
        'groups' => ['tool:read']
    ],
)]
class Tool
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tool:read", "game:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tool:read", "tool:write", "game:read"})
     * @Assert\NotBlank()
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=MediaLibrary::class, inversedBy="tools")
     * @Groups({"tool:read", "tool:write"})
     */
    private ?MediaLibrary $media;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tool:read", "tool:write", "game:read"})
     * @Assert\NotBlank()
     */
    private string $href;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="tools")
     * @Groups({"tool:read", "tool:write"})
     */
    private ?Game $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMedia(): ?MediaLibrary
    {
        return $this->media;
    }

    public function setMedia(?MediaLibrary $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(?string $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }
}
