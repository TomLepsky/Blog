<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\DTO\TagOutput;
use App\Embeddable\MetaInformation;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Security\Voter\VoterAttribute;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ORM\Table(name="tag",indexes={
 *     @ORM\Index(name="tag_slug_index", columns={"slug"})
 * })
 * @UniqueEntity("slug")
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['tagCollection:read'],
                'skip_null_values' => true
            ],
        ],
        'post' => [
            "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
        ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['tagItem:read'],
                'skip_null_values' => true
            ],
            'output' => TagOutput::class
        ],
        'put' => [
            "security" => "is_granted('" . VoterAttribute::EDIT . "', object)"
        ],
        'delete' => [
            "security" => "is_granted('" . VoterAttribute::DELETE . "', object)"
        ]
    ],
    denormalizationContext: [
        'groups' => ['tag:write']
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['game.slug' => 'exact'])]
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tagItem:read", "tagCollection:read", "articleItem:read", "articleCollection:read"})
     * @ApiProperty(identifier=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tagItem:read", "tagCollection:read", "articleItem:read", "articleCollection:read", "tag:write"})
     * @Assert\NotBlank()
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tagItem:read", "tagCollection:read", "articleItem:read", "articleCollection:read", "tag:write"})
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/[^\w-]+/",
     *     match=false,
     *     message="Slug should contain only letters, digits or symbols: -_"
     * )
     * @ApiProperty(identifier=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tagItem:read", "tagCollection:read"})
     */
    private ?int $articlesQuantity = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagItem:read", "tag:write"})
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagItem:read", "tag:write"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagItem:read", "tag:write"})
     */
    private ?string $ogTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagItem:read", "tag:write"})
     */
    private ?string $ogDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagItem:read", "tag:write"})
     */
    private ?string $keyWords;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="tags")
     */
    private ?Collection $articles;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="tags")
     * @Groups({"tagItem:read", "tagCollection:read", "tag:write"})
     */
    private ?Game $game;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addTag($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeTag($this);
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
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

    public function getArticlesQuantity(): ?int
    {
        return $this->articlesQuantity;
    }

    public function setArticlesQuantity(?int $articlesQuantity): void
    {
        $this->articlesQuantity = $articlesQuantity;
    }
}
