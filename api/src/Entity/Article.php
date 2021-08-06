<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\ArticleOutput;
use App\DTO\ArticleTranslationInput;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post',
        'getCollection' => [
            'method' => 'get',
            'path' => '/articles/collection',
            'normalization_context' => ['groups' => ['ArticleCollection:read']],
            'controller' => 'App\Controller\ArticleController::getTranslatableCollection',
            'output' => ArticleOutput::class
        ]
    ],
    itemOperations: [
        'get',
        'put',
        'delete',
        'getItem' => [
            'method' => 'get',
            'path' => '/articles/item/{id}',
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['articleItem:read']],
            'controller' => 'App\Controller\ArticleController::getTranslatableItem',
            'output' => ArticleOutput::class
        ]
    ],
    denormalizationContext: [
        'groups' => ['article:write']
    ],
    normalizationContext: [
        'groups' => ['article:read']
    ],
)]
class Article
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"article:read", "articleCollection:read", "articleItem:read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ArticleTranslation::class, mappedBy="article", orphanRemoval=true)
     * @Groups({"article:read", "article:write", "articleCollection:read", "articleItem:read"})
     */
    private $articleTranslations;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="articles")
     * @Groups({"article:read", "article:write", "articleCollection:read", "articleItem:read"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, inversedBy="children")
     * @MaxDepth(1)
     * @Groups({"article:read", "article:write", "articleCollection:read", "articleItem:read"})
     */
    #[ApiProperty(
        readableLink: true,
        writableLink: true
    )]
    private $parents;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, mappedBy="parents")
     * @MaxDepth(1)
     * @Groups({"article:read", "article:write", "articleCollection:read", "articleItem:read"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="popularArticles")
     * @Groups({"article:read"})
     */
    private $game;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"article:read", "articleCollection:read", "articleItem:read"})
     */
    private $createdAt;

    #[Pure]
    public function __construct()
    {
        $this->articleTranslations = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setDefaultCreatedAt() : void
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleTranslations(): Collection
    {
        return $this->articleTranslations;
    }

    public function addArticleTranslation(ArticleTranslation $articleTranslation): self
    {
        if (!$this->articleTranslations->contains($articleTranslation)) {
            $this->articleTranslations[] = $articleTranslation;
            $articleTranslation->setArticle($this);
        }

        return $this;
    }

    public function removeArticleTranslation(ArticleTranslation $articleTranslation): self
    {
        if ($this->articleTranslations->removeElement($articleTranslation)) {
            // set the owning side to null (unless already changed)
            if ($articleTranslation->getArticle() === $this) {
                $articleTranslation->setArticle(null);
            }
        }

        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->addParent($this);
        }
        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParents()->contains($this)) {
                $child->removeParent($this);
            }
        }
        return $this;
    }

    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
            $parent->addChild($this);
        }
        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parents->removeElement($parent)) {
            if ($parent->getChildren()->contains($this)) {
                $parent->removeChild($this);
            }
        }
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
