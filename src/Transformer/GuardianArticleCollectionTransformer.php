<?php

declare(strict_types=1);

namespace App\Transformer;

use App\ApiResource\Article;
use App\Dto\Article\UidDetails;
use App\Enum\ArticleSource;
use App\Factory\UidFactory;
use DateTimeImmutable;

class GuardianArticleCollectionTransformer
{
    public function __construct(private readonly UidFactory $uidFactory)
    {
    }

    /**
     * @param array<string, mixed> $data
     * @return Article[]
     */
    public function transform(array $data): array
    {
        $results = $data['response']['results'] ?? [];

        return array_map(
            function (array $result): Article {
                $article = new Article();

                $article->uid = $this->uidFactory->createUid(new UidDetails($result['id'], ArticleSource::GUARDIAN));
                $article->title = $result['webTitle'];
                $article->link = $result['webUrl'];
                $article->publicationDate = DateTimeImmutable::createFromFormat(
                    \DateTimeInterface::ISO8601,
                    $result['webPublicationDate']
                );
                $article->source = ArticleSource::GUARDIAN;

                return $article;
            },
            $results
        );
    }
}
