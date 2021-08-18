<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use App\Security\Voter\VoterAttribute;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
        ]
    ],
    itemOperations: [
        'get',
        'put' => [
            "security" => "is_granted('" . VoterAttribute::EDIT . "', object)"
        ],
        'delete' => [
            "security" => "is_granted('" . VoterAttribute::DELETE . "', object)"
        ]
    ],
    denormalizationContext: [
        'groups' => ['game:write']
    ],
    normalizationContext: [
        'groups' => ['game:read']
    ],
)]
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"game:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"game:read", "game:write"})
     * @Assert\NotBlank()
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="game")
     * @Groups({"game:read", "game:write"})
     */
    private ?Collection $popularArticles;

    /**
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="game")
     * @Groups({"game:read", "game:write"})
     */
    private ?Collection $tags;

    /**
     * @ORM\OneToMany(targetEntity=Tool::class, mappedBy="game")
     * @Groups({"game:read", "game:write"})
     */
    private ?Collection $tools;

    public function __construct()
    {
        $this->popularArticles = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->tools = new ArrayCollection();
    }

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

    public function getPopularArticles(): ?Collection
    {
        return $this->popularArticles;
    }

    public function addPopularArticles(Article $popularArticle): self
    {
        if (!$this->popularArticles->contains($popularArticle)) {
            $this->popularArticles[] = $popularArticle;
            $popularArticle->setGame($this);
        }
        return $this;
    }

    public function removePopularArticle(Article $popularArticle): self
    {
        if ($this->popularArticles->removeElement($popularArticle)) {
            if ($popularArticle->getGame() === $this) {
                $popularArticle->setGame(null);
            }
        }
        return $this;
    }

    public function getTags(): ?Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setGame($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getGame() === $this) {
                $tag->setGame(null);
            }
        }

        return $this;
    }

    public function getTools(): ?Collection
    {
        return $this->tools;
    }

    public function addTool(Tool $tool): self
    {
        if (!$this->tools->contains($tool)) {
            $this->tools[] = $tool;
            $tool->setGame($this);
        }

        return $this;
    }

    public function removeTool(Tool $tool): self
    {
        if ($this->tools->removeElement($tool)) {
            // set the owning side to null (unless already changed)
            if ($tool->getGame() === $this) {
                $tool->setGame(null);
            }
        }

        return $this;
    }
}
