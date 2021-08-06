<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GameTranslationRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['gameTranslation:write']
    ],
    normalizationContext: [
        'groups' => ['gameTranslation:read']
    ],
)]
class GameTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"gameTranslation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"gameTranslation:read", "gameTranslation:write"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="gameTranslations")
     * @Groups({"gameTranslation:read", "gameTranslation:write"})
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity=Locale::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"gameTranslation:read", "gameTranslation:write"})
     */
    private $locale;

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

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

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
}
