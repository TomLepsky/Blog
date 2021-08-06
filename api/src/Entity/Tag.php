<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\DTO\TagOutput;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post',
        'getCollection' => [
            'method' => 'get',
            'path' => '/tags/collection',
            'normalization_context' => ['groups' => ['tagCollection:read']],
            'controller' => 'App\Controller\TagController::getTranslatableCollection',
            'output' => TagOutput::class
        ]
    ],
    itemOperations: [
        'get',
        'put',
        'delete',
        'getItem' => [
            'method' => 'get',
            'path' => '/tags/item/{id}',
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['tagItem:read']],
            'controller' => 'App\Controller\TagController::getTranslatableItem',
            'output' => TagOutput::class
        ]
    ],
    denormalizationContext: [
        'groups' => ['tag:write']
    ],
    normalizationContext: [
        'groups' => ['tag:read']
    ],
)]
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tag:read", "articleCollection:read", "tagCollection:read", "tagItem:read", "articleCollection:read", "articleItem:read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=TagTranslation::class, mappedBy="tag", orphanRemoval=true)
     * @Groups({"tag:read", "tag:write", "articleCollection:read", "tagCollection:read", "tagItem:read"})
     */
    private $tagTranslations;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="tags")
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="tags")
     */
    private $game;

    public function __construct()
    {
        $this->tagTranslations = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagTranslations(): ?Collection
    {
        return $this->tagTranslations;
    }

    public function addTagTranslation(TagTranslation $tagTranslation): self
    {
        if (!$this->tagTranslations->contains($tagTranslation)) {
            $this->tagTranslations[] = $tagTranslation;
            $tagTranslation->setTag($this);
        }

        return $this;
    }

    public function removeTagTranslation(TagTranslation $tagTranslation): self
    {
        if ($this->tagTranslations->removeElement($tagTranslation)) {
            // set the owning side to null (unless already changed)
            if ($tagTranslation->getTag() === $this) {
                $tagTranslation->setTag(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
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
}
