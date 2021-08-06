<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\ArticleTranslationInput;
use App\Repository\ArticleTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleTranslationRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['articleTranslation:write']
    ],
    input: ArticleTranslationInput::class,
    normalizationContext: [
        'groups' => ['articleTranslation:read']
    ]
)]
class ArticleTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"articleTranslation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"articleTranslation:read", "articleTranslation:write", "articleCollection:read", "articleItem:read"})
     */
    private $header;

    /**
     * @ORM\Column(type="text")
     * @Groups({"articleTranslation:read", "articleTranslation:write", "articleCollection:read", "articleItem:read"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="articleTranslations")
     * @Groups({"articleTranslation:read", "articleTranslation:write"})
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Locale::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"articleTranslation:read", "articleTranslation:write", "articleCollection:read", "articleItem:read"})
     */
    private $locale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"articleTranslation:read", "articleCollection:read", "articleItem:read"})
     */
    private $secondsForReading;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"articleTranslation:read", "articleCollection:read", "articleItem:read"})
     */
    private $updatedAt;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(?Locale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getSecondsForReading(): ?int
    {
        return $this->secondsForReading;
    }

    public function setSecondsForReading(?int $secondsForReading): self
    {
        $this->secondsForReading = $secondsForReading;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
