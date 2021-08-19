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
        'get',
        'post' => [
//            "security_post_denormalize" => "is_granted('" . VoterAttribute::CREATE . "', object)",
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
        'get',
        'delete' => [
//            "security" => "is_granted('" . VoterAttribute::DELETE . "', object)"
        ]
    ],
    denormalizationContext: [
        'groups' => ['mediaObject:write']
    ],
    normalizationContext: [
        'groups' => ['mediaObject:read']
    ],
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
     * @Groups({"mediaObject:read"})
     */
    public ?string $contentUrl = null;

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

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): void
    {
        $this->contentUrl = $contentUrl;
    }
}
