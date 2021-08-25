<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\GameOutput;
use App\Repository\GameRepository;
use App\Security\Voter\VoterAttribute;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 * @ORM\Table(name="game",indexes={
 *     @ORM\Index(name="game_slug_index", columns={"slug"})
 * })
 * @UniqueEntity("slug")
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            "normalization_context" => [
                "groups" => ["gameCollection:read"],
            ],
        ],
        'post' => [
//            "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
        ]
    ],
    itemOperations: [
        'get' => [
            "normalization_context" => [
                "groups" => ["gameItem:read"],
            ],
        ],
        'put' => [
//            "security" => "is_granted('" . VoterAttribute::EDIT . "', object)"
        ],
        'delete' => [
//            "security" => "is_granted('" . VoterAttribute::DELETE . "', object)"
        ]
    ],
    denormalizationContext: [
        'groups' => ['game:write']
    ],
    normalizationContext: [
        'skip_null_values' => true
    ],
    output: GameOutput::class
)]
class Game extends MetaInformation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"gameItem:read", "gameCollection:read", "articleItem:read", "articleCollection:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"gameItem:read", "gameCollection:read", "game:write"})
     * @Assert\NotBlank()
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"gameItem:read", "gameCollection:read", "game:write", "articleItem:read", "articleCollection:read"})
     * @Assert\NotBlank()
     * @Assert\Regex("/[\w\d-]+/")
     */
    private string $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"game:write"})
     */
    private int $weight = 100;

    /**
     * @Groups({"gameItem:read", "gameCollection:read"})
     */
    private int $articlesCount;

    /**
     * @ORM\OneToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * @Groups({"gameItem:read", "gameCollection:read", "game:write"})
     */
    private ?MediaObject $image;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="game")
     */
    private ?Collection $articles;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="popularGame")
     * @Groups({"game:write"})
     */
    private ?Collection $popularArticles;

    /**
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="game")
     * @Groups({"game:write"})
     */
    private ?Collection $tags;

    /**
     * @ORM\OneToMany(targetEntity=Tool::class, mappedBy="game")
     * @Groups({"game:write"})
     */
    private ?Collection $tools;

    public function __construct()
    {
        $this->popularArticles = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->tools = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
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

    public function getArticles(): ?Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setGame($this);
        }
        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            if ($article->getGame() === $this) {
                $article->setGame(null);
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): void
    {
        $this->image = $image;
    }

    public function getArticlesCount(): int
    {
        return $this->articlesCount;
    }

    public function setArticlesCount(int $articlesCount): void
    {
        $this->articlesCount = $articlesCount;
    }
}
