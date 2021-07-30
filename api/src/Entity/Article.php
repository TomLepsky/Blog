<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['article:write']
    ],
    normalizationContext: [
        'groups' => ['article:read']
    ]
)]
class Article
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"article:read", "article:write"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ArticleTranslation::class, mappedBy="article", orphanRemoval=true)
     * @Groups({"article:read", "article:write"})
     */
    private $articleTranslation;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="articles")
     * @Groups({"article:read", "article:write"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, inversedBy="children")
     * @MaxDepth(4)
     * @Groups({"article:read", "article:write"})
     */
    #[ApiProperty(
        readableLink: true,
        writableLink: true
    )]
    private $parents;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, mappedBy="parents")
     * @Groups({"article:read", "article:write"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="popularArticles")
     * @Groups({"article:read", "article:write"})
     */
    private $game;

    #[Pure]
    public function __construct()
    {
        $this->articleTranslation = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleTranslation(): Collection
    {
        return $this->articleTranslation;
    }

    public function addArticleTranslation(ArticleTranslation $articleTranslation): self
    {
        if (!$this->articleTranslation->contains($articleTranslation)) {
            $this->articleTranslation[] = $articleTranslation;
            $articleTranslation->setArticle($this);
        }

        return $this;
    }

    public function removeArticleTranslation(ArticleTranslation $articleTranslation): self
    {
        if ($this->articleTranslation->removeElement($articleTranslation)) {
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
//            $child->setParent($this);
        }
        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
//            if ($child->getParent() === $this) {
//                $child->setParent(null);
//            }
        }
        return $this;
    }

    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParents(self $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
//            $child->setParent($this);
        }
        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->children->removeElement($parent)) {
            // set the owning side to null (unless already changed)
//            if ($child->getParent() === $this) {
//                $child->setParent(null);
//            }
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
}
