<?php

namespace App\DTO;

use App\Entity\Locale;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as BlogAssert;

class ArticleTranslationInput
{
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[Groups(["articleTranslation:read", "articleTranslation:write"])]
    public ?string $header;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    #[Groups(["articleTranslation:read", "articleTranslation:write"])]
    public ?string $content;

    #[Assert\Type(type: 'string')]
    #[Groups(["articleTranslation:read", "articleTranslation:write"])]
    public ?string $article;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
//    #[BlogAssert\Identifier(['entityClass' => Locale::class])]
    #[Groups(["articleTranslation:read", "articleTranslation:write"])]
    public ?string $locale;
}
