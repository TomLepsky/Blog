<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
            ],
        ],
        'post' => [
//            "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
        ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['tagItem:read'],
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
        'groups' => ['tag:write']
    ],
    normalizationContext: [
    'skip_null_values' => true
],
)]
class Tag extends MetaInformation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tagItem:read", "tagCollection:read", "articleItem:read", "articleCollection:read"})
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
     * @Assert\Regex("/[\w\d-]+/")
     */
    private string $slug;

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
}
