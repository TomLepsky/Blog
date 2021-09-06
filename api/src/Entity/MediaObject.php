<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateMediaObjectAction;
use App\Repository\MediaObjectRepository;
use App\Security\Voter\VoterAttribute;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=MediaObjectRepository::class)
 * @Vich\Uploadable
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'get',
            'path' => '/media-objects',
        ],
        'post' => [
            'method' => 'post',
            'path' => '/media-objects',
                "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
            'controller' => CreateMediaObjectAction::class,
            'deserialize' => false,
            'validation_groups' => ['Default', 'mediaObject:create'],
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    ],
    itemOperations: [
        'get' => [
            'method' => 'get',
            'path' => '/media-objects/{id}',
        ],
        'delete' => [
            'method' => 'delete',
            'path' => '/media-objects/{id}',
                "security" => "is_granted('" . VoterAttribute::DELETE . "', object)"
        ]
    ],
    denormalizationContext: [
        'groups' => ['mediaObject:write']
    ],
    normalizationContext: [
        'groups' => ['mediaObject:read']
    ],
    routePrefix: '/api'
)]
class MediaObject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"mediaObject:read"})
     */
    private int $id;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="fileName", size="fileSize")
     * @Assert\NotNull(groups={"mediaObject:create"})
     */
    private ?File $file;

    /**
     * @ORM\Column(type="string")
     * @Groups({"mediaObject:read"})
     */
    private ?string $fileName;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"mediaObject:read"})
     */
    private ?int $fileSize;

    /**
     * @Groups({"mediaObject:read", "gameItem:read", "gameCollection:read"})
     */
    private ?string $original = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"mediaObject:read", "gameItem:read", "gameCollection:read"})
     */
    private ?string $placeholder = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAECAMAAACA5l7/AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAV1BMVEUAAAB6oZtKaWZxn5aGraUhPT9Lamk8VlYmQUIwd3hig35ihYApQD+U18lhfXpZcW6CqKAPJysvRENDX15EYWBIaGcpRkgpPj8xcG8zgH0xZWQ3enoAAACq7IQCAAAAHHRSTlMAAAAAAAAAAAAAGyQCBIOvEwNd1u5ZBUal3HoG3jmIAgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQflCBgKEBx81N/oAAAALklEQVQI12NgYGBg5OLmYWIAAWZePn4BFhCLVVBIWESUjR3I5BATl5CUkuZkAAAXPQF7p/dzxAAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMS0wOC0yNFQxMDoxNjoyOC0wNDowMGt2sFYAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjEtMDgtMjRUMTA6MTY6MjgtMDQ6MDAaKwjqAAAAAElFTkSuQmCC";

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"mediaObject:read"})
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Tool::class, mappedBy="mediaObject")
     */
    private ?Collection $tools;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="mediaObjects")
     */
    private ?Collection $articles;

    public function __construct()
    {
        $this->tools = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getFile() : ?File
    {
        return $this->file;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getTools(): ?Collection
    {
        return $this->tools;
    }

    public function getArticles(): ?Collection
    {
        return $this->articles;
    }

    public function getOriginal(): ?string
    {
        return $this->original;
    }

    public function setOriginal(?string $original): void
    {
        $this->original = $original;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }
}
