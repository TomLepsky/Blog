<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use App\Security\Voter\VoterAttribute;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
     * @Groups({"article:read", "game:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"article:read", "article:write", "game:read"})
     * @Assert\NotBlank()
     */
    private string $header;

    /**
     * @ORM\Column(type="text")
     * @Groups({"article:read", "article:write"})
     * @Assert\NotBlank()
     */
    private string $content;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="articles")
     * @Groups({"article:read", "article:write"})
     */
    private ?Collection $tags;

    /**
     * @ORM\ManyToMany(targetEntity=MediaObject::class, inversedBy="articles")
     * @Groups({"article:read", "article:write"})
     */
    private ?Collection $mediaObjects;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, inversedBy="children")
     * @MaxDepth(1)
     * @Groups({"article:read", "article:write"})
     */
    #[ApiProperty(
        readableLink: true,
        writableLink: true
    )]
    private ?Collection $parents;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, mappedBy="parents")
     * @MaxDepth(1)
     * @Groups({"article:read", "article:write"})
     */
    private ?Collection $children;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="popularArticles")
     */
    private ?Game $game;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="articles")
     */
    private ?Game $popularGame;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"article:read"})
     */
    private int $secondsForReading;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"article:read"})
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"article:read"})
     */
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->mediaObjects = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() : void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->secondsForReading =  $this->calculateReadingTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() : void
    {
        $this->updatedAt = new DateTime();
        $this->secondsForReading = $this->calculateReadingTime();
    }

    #[Pure]
    private function calculateReadingTime() : int
    {
        return (int) count(explode(" ", $this->content)) * 0.3;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getMediaObjects(): ?Collection
    {
        return $this->mediaObjects;
    }

    public function addMediaObject(MediaObject $mediaObject): self
    {
        if (!$this->mediaObjects->contains($mediaObject)) {
            $this->mediaObjects[] = $mediaObject;
        }

        return $this;
    }

    public function removeMediaObject(MediaObject $mediaObject): self
    {
        $this->mediaObjects->removeElement($mediaObject);

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

    public function getPopularGame(): ?Game
    {
        return $this->popularGame;
    }

    public function setPopularGame(?Game $popularGame): self
    {
        $this->popularGame = $popularGame;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSecondsForReading(): ?int
    {
        return $this->secondsForReading;
    }

    public function setSecondsForReading(int $secondsForReading): self
    {
        $this->secondsForReading = $secondsForReading;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
