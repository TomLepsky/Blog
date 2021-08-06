<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\ToolOutput;
use App\Repository\ToolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ToolRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post',
        'getCollection' => [
            'method' => 'get',
            'path' => '/tools/collection',
            'normalization_context' => ['groups' => ['toolCollection:read']],
            'controller' => 'App\Controller\ToolController::getTranslatableCollection',
            'output' => ToolOutput::class
        ]
    ],
    itemOperations: [
        'get',
        'put',
        'delete',
        'getItem' => [
            'method' => 'get',
            'path' => '/tools/item/{id}',
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['toolItem:read']],
            'controller' => 'App\Controller\ToolController::getTranslatableItem',
            'output' => ToolOutput::class
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
     * @Groups({"tool:read", "toolCollection:read", "toolItem:read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ToolTranslation::class, mappedBy="tool")
     * @Groups({"tool:read", "tool:write", "toolCollection:read", "toolItem:read"})
     */
    private $toolTranslations;

    /**
     * @ORM\ManyToOne(targetEntity=MediaLibrary::class, inversedBy="tools")
     * @Groups({"tool:read", "tool:write", "toolCollection:read", "toolItem:read"})
     */
    private $media;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tool:read", "tool:write", "toolCollection:read", "toolItem:read"})
     */
    private $href;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="tools")
     * @Groups({"tool:read", "tool:write", "toolCollection:read", "toolItem:read"})
     */
    private $game;

    public function __construct()
    {
        $this->toolTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getToolTranslations(): Collection
    {
        return $this->toolTranslations;
    }

    public function addToolTranslation(ToolTranslation $toolTranslation): self
    {
        if (!$this->toolTranslations->contains($toolTranslation)) {
            $this->toolTranslations[] = $toolTranslation;
            $toolTranslation->setTool($this);
        }

        return $this;
    }

    public function removeToolTranslation(ToolTranslation $toolTranslation): self
    {
        if ($this->toolTranslations->removeElement($toolTranslation)) {
            // set the owning side to null (unless already changed)
            if ($toolTranslation->getTool() === $this) {
                $toolTranslation->setTool(null);
            }
        }

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
