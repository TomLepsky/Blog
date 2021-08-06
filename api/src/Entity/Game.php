<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['game:write']
    ],
    normalizationContext: [
        'groups' => ['game:read']
    ],
)]
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"game:read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=GameTranslation::class, mappedBy="game", orphanRemoval=true)
     * @Groups({"game:read", "game:write"})
     */
    private $gameTranslations;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="game")
     * @Groups({"game:read", "game:write"})
     */
    private $popularArticles;

    /**
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="game")
     * @Groups({"game:read", "game:write"})
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=Tool::class, mappedBy="game")
     * @Groups({"game:read", "game:write"})
     */
    private $tools;

    public function __construct()
    {
        $this->gameTranslations = new ArrayCollection();
        $this->popularArticles = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->tools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameTranslations(): Collection
    {
        return $this->gameTranslations;
    }

    public function addGameTranslation(GameTranslation $gameTranslation): self
    {
        if (!$this->gameTranslations->contains($gameTranslation)) {
            $this->gameTranslations[] = $gameTranslation;
            $gameTranslation->setGame($this);
        }

        return $this;
    }

    public function removeGameTranslation(GameTranslation $gameTranslation): self
    {
        if ($this->gameTranslations->removeElement($gameTranslation)) {
            // set the owning side to null (unless already changed)
            if ($gameTranslation->getGame() === $this) {
                $gameTranslation->setGame(null);
            }
        }

        return $this;
    }

    public function getPopularArticles(): Collection
    {
        return $this->popularArticles;
    }

    public function addPopularArticles(Article $popularArticle): self
    {
        if (!$this->popularArticles->contains($popularArticle)) {
            $this->popularArticles[] = $popularArticle;
            $popularArticle->setGame($this);
        }
        return $this;
    }

    public function removePopularArticle(Article $popularArticle): self
    {
        if ($this->popularArticles->removeElement($popularArticle)) {
            if ($popularArticle->getGame() === $this) {
                $popularArticle->setGame(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setGame($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getGame() === $this) {
                $tag->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tool[]
     */
    public function getTools(): Collection
    {
        return $this->tools;
    }

    public function addTool(Tool $tool): self
    {
        if (!$this->tools->contains($tool)) {
            $this->tools[] = $tool;
            $tool->setGame($this);
        }

        return $this;
    }

    public function removeTool(Tool $tool): self
    {
        if ($this->tools->removeElement($tool)) {
            // set the owning side to null (unless already changed)
            if ($tool->getGame() === $this) {
                $tool->setGame(null);
            }
        }

        return $this;
    }
}
