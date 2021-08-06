<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ToolTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ToolTranslationRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['toolTranslation:write']
    ],
    normalizationContext: [
        'groups' => ['toolTranslation:read']
    ],
)]
class ToolTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"toolTranslation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"toolTranslation:read", "toolTranslation:write", "toolCollection:read", "toolItem:read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Locale::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"toolTranslation:read", "toolTranslation:write", "toolCollection:read", "toolItem:read"})
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity=Tool::class, inversedBy="toolTranslations")
     * @Groups({"toolTranslation:read", "toolTranslation:write"})
     */
    private $tool;

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

    public function getTool(): ?Tool
    {
        return $this->tool;
    }

    public function setTool(?Tool $tool): self
    {
        $this->tool = $tool;

        return $this;
    }
}
