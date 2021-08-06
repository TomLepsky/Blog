<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagTranslationRepository;
use App\Translation\Translatable;
use App\Translation\Translation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagTranslationRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['tagTranslation:write']
    ],
    normalizationContext: [
        'groups' => ['tagTranslation:read']
    ],
)]
class TagTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tagTranslation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tagTranslation:read", "tagTranslation:write", "articleCollection:read", "tagCollection:read", "tagItem:read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Locale::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"tagTranslation:read", "tagTranslation:write", "tagCollection:read", "tagItem:read"})
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="tagTranslations")
     * @Groups({"tagTranslation:read"})
     */
    private $tag;

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

    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(?Locale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocaleName() : string
    {
        return $this->locale->getName();
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
