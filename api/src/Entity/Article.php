<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Config;
use App\Controller\ArticleController\GetArticleItem;
use App\Controller\ArticleController\GetMainPageArticles;
use App\Controller\ArticleController\GetPopularArticles;
use App\Controller\ArticleController\GetRelatedArticles;
use App\Controller\ArticleController\SearchArticlesAction;
use App\DTO\Article\ArticleCollectionOutput;
use App\DTO\Article\ArticleItemOutput;
use App\Repository\ArticleRepository;
use App\Security\Voter\VoterAttribute;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Table(name="article",indexes={
 *     @ORM\Index(name="article_slug_index", columns={"slug"})
 * })
 * @UniqueEntity("slug")
 * @ORM\HasLifecycleCallbacks()
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'get',
            'path' => '/articles',
            'order' => ['createdAt' => 'DESC'],
            'normalization_context' => [
                'groups' => ['articleCollection:read'],
            ],
        ],
        Config::API_BLOG_NAMESPACE . '_articles_get' => [
            'method' => 'get',
            'path' => '/' . Config::API_BLOG_NAMESPACE . '/articles',
            'normalization_context' => [
                'groups' => ['articleCollection:read'],
                'skip_null_values' => true
            ],
            'order' => ['createdAt' => 'DESC'],
            'output' => ArticleCollectionOutput::class,
        ],
        Config::API_BLOG_NAMESPACE . '_articles_main' => [
            'method' => 'get',
            'path' => '/' . Config::API_BLOG_NAMESPACE . '/articles/main',
            'controller' => GetMainPageArticles::class,
            'normalization_context' => [
                'groups' => ['articleCollection:read'],
                'skip_null_values' => true
            ],
            'output' => ArticleCollectionOutput::class,
        ],
        Config::API_BLOG_NAMESPACE . '_articles_popular' => [
            'method' => 'get',
            'path' => '/' . Config::API_BLOG_NAMESPACE . '/articles/popular',
            'controller' => GetPopularArticles::class,
            'normalization_context' => [
                'groups' => ['articleCollection:read'],
                'skip_null_values' => true
            ],
            'output' => ArticleCollectionOutput::class,
        ],
        Config::API_BLOG_NAMESPACE . '_articles_search' => [
            'method' => 'get',
            'path' => '/' . Config::API_BLOG_NAMESPACE . '/articles/search',
            'controller' => SearchArticlesAction::class,
            'normalization_context' => [
                'groups' => ['articleCollection:read'],
                'skip_null_values' => true
            ],
            'read' => false,
            'output' => ArticleCollectionOutput::class,
        ],
        Config::API_BLOG_NAMESPACE . '_articles_related' => [
            'method' => 'get',
            'path' => '/' . Config::API_BLOG_NAMESPACE . '/articles/related',
            'controller' => GetRelatedArticles::class,
            'normalization_context' => [
                'groups' => ['articleCollection:read'],
                'skip_null_values' => true
            ],
            'read' => false,
            'output' => ArticleCollectionOutput::class,
        ],
        'post' => [
            "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
        ]
    ],
    itemOperations: [
        'get' => [
            'method' => 'get',
            'path' => '/articles/{slug}',
            'normalization_context' => [
                'groups' => ['articleItem:read'],
            ],
        ],
        Config::API_BLOG_NAMESPACE . '_article_get' => [
            'method' => 'get',
            'path' => '/' . Config::API_BLOG_NAMESPACE . '/articles/{gameSlug}/{articleSlug}',
            'controller' => GetArticleItem::class,
            'normalization_context' => [
                'groups' => ['articleItem:read'],
                'skip_null_values' => true
            ],
            'read' => false,
            'output' => ArticleItemOutput::class,
        ],
        'put' => [
            "security" => "is_granted('" . VoterAttribute::EDIT . "', object)"
        ],
        'delete' => [
            "security" => "is_granted('" . VoterAttribute::DELETE . "', object)"
        ]
    ],
    attributes: [
        'pagination_client_items_per_page' => true,
    ],
    denormalizationContext: [
        'groups' => ['article:write']
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['game.slug' => 'exact', 'tags.slug' => 'exact', 'header' => 'partial'])]
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"articleItem:read", "articleCollection:read", "game:read"})
     * @ApiProperty(identifier=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"articleItem:read", "articleCollection:read", "article:write", "game:read"})
     * @Assert\NotBlank()
     */
    private string $header;

    /**
     * @ORM\Column(type="text")
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     * @Assert\NotBlank()
     */
    private ?string $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/[^\w-]+/",
     *     match=false,
     *     message="Slug should contain only letters, digits or symbols: -_"
     * )
     * @ApiProperty(iri="https://schema.org/identifier", identifier=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?string $ogTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?string $ogDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?string $keyWords;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="articles")
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?Collection $tags;

    /**
     * @ORM\OneToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(name="preview_image_id", referencedColumnName="id")
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?MediaObject $previewImage;

    /**
     * @ORM\OneToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(name="detail_image_id", referencedColumnName="id")
     * @Groups({"articleItem:read", "articleCollection:read", "article:write"})
     */
    private ?MediaObject $detailImage;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, inversedBy="parents")
     * @ORM\JoinTable(
     *     name = "article_article",
     *     joinColumns = {@ORM\JoinColumn(name = "article_source", referencedColumnName = "id")},
     *     inverseJoinColumns = {@ORM\JoinColumn(name = "article_target", referencedColumnName = "id")}
     * )
     * @MaxDepth(1)
     * @Groups({"articleItem:read", "articleItem:write"})
     */
    #[ApiProperty(
        readableLink: true,
        writableLink: true
    )]
    private ?Collection $children;

    /**
     * @ORM\ManyToMany(targetEntity=self::class, mappedBy="children")
     * @MaxDepth(1)
     */
    #[ApiProperty(
        readableLink: true,
        writableLink: true
    )]
    private ?Collection $parents;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="articles")
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    private ?Game $game;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="popularArticles")
     */
    private ?Game $popular;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    private int $timeToRead;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"articleItem:read", "articleCollection:read"})
     */
    private DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() : void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->timeToRead =  $this->calculateReadingTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() : void
    {
        $this->updatedAt = new DateTime();
        $this->timeToRead = $this->calculateReadingTime();
    }

    private function calculateReadingTime() : int
    {
        return (int) ceil(count(explode(" ", $this->content)) * 0.005);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHeader(): string
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

    public function setContent(?string $content): self
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

    public function getPopular(): ?Game
    {
        return $this->popular;
    }

    public function setPopular(?Game $popular): self
    {
        $this->popular = $popular;

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

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getPreviewImage(): ?MediaObject
    {
        return $this->previewImage;
    }

    public function setPreviewImage(?MediaObject $previewImage): void
    {
        $this->previewImage = $previewImage;
    }

    public function getDetailImage(): ?MediaObject
    {
        return $this->detailImage;
    }

    public function setDetailImage(?MediaObject $detailImage): void
    {
        $this->detailImage = $detailImage;
    }

    public function getTimeToRead(): int
    {
        return $this->timeToRead;
    }

    public function setTimeToRead(int $timeToRead): void
    {
        $this->timeToRead = $timeToRead;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getOgTitle(): ?string
    {
        return $this->ogTitle;
    }

    public function setOgTitle(?string $ogTitle): void
    {
        $this->ogTitle = $ogTitle;
    }

    public function getOgDescription(): ?string
    {
        return $this->ogDescription;
    }

    public function setOgDescription(?string $ogDescription): void
    {
        $this->ogDescription = $ogDescription;
    }

    public function getKeyWords(): ?string
    {
        return $this->keyWords;
    }

    public function setKeyWords(?string $keyWords): void
    {
        $this->keyWords = $keyWords;
    }

    public function __toString(): string
    {
        return $this->getHeader();
    }
}
