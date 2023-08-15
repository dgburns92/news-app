<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use App\Enum\ArticleSource;
use App\State\Provider\ArticleCollectionProvider;
use App\State\Provider\ArticleProvider;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ApiResource(
    operations: [
        new GetCollection(
            openapi: new Operation(parameters: [new Parameter('keyword', 'query')]),
            paginationEnabled: false,
            provider: ArticleCollectionProvider::class
        ),
        new Get(
            uriTemplate: '/articles/{uid}',
            provider: ArticleProvider::class
        ),
    ],
    normalizationContext: ['groups' => ['read']],
)]
class Article
{
    #[ApiProperty(identifier: true)]
    #[Groups(groups: ['read'])]
    public string $uid;

    #[Groups(groups: ['read'])]
    public string $title;

    #[Groups(groups: ['read'])]
    public string $link;

    #[Groups(groups: ['read'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    public DateTimeInterface $publicationDate;

    #[Groups(groups: ['read'])]
    public ArticleSource $source;
}
