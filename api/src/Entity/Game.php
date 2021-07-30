<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
#[ApiResource]
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=GameTranslation::class, mappedBy="game", orphanRemoval=true)
     */
    private $gameTranslation;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="game")
     */
    private $popularArticles;

    public function __construct()
    {
        $this->gameTranslation = new ArrayCollection();
        $this->popularFields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|GameTranslation[]
     */
    public function getGameTranslation(): Collection
    {
        return $this->gameTranslation;
    }

    public function addGameTranslation(GameTranslation $gameTranslation): self
    {
        if (!$this->gameTranslation->contains($gameTranslation)) {
            $this->gameTranslation[] = $gameTranslation;
            $gameTranslation->setGame($this);
        }

        return $this;
    }

    public function removeGameTranslation(GameTranslation $gameTranslation): self
    {
        if ($this->gameTranslation->removeElement($gameTranslation)) {
            // set the owning side to null (unless already changed)
            if ($gameTranslation->getGame() === $this) {
                $gameTranslation->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getPopularFields(): Collection
    {
        return $this->popularFields;
    }

    public function addPopularField(Article $popularField): self
    {
        if (!$this->popularFields->contains($popularField)) {
            $this->popularFields[] = $popularField;
            $popularField->setGame($this);
        }

        return $this;
    }

    public function removePopularField(Article $popularField): self
    {
        if ($this->popularFields->removeElement($popularField)) {
            // set the owning side to null (unless already changed)
            if ($popularField->getGame() === $this) {
                $popularField->setGame(null);
            }
        }

        return $this;
    }
}
