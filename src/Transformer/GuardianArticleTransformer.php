<?php

declare(strict_types=1);

namespace App\Transformer;

use App\ApiResource\Article;
use App\Dto\Article\UidDetails;
use App\Enum\ArticleSource;
use App\Factory\UidFactory;
use DateTimeImmutable;

class GuardianArticleTransformer
{
    public function __construct(private readonly UidFactory $uidFactory)
    {
    }

    /** @param array<string, mixed> $data */
    public function transform(array $data): Article
    {
        $content = $data['response']['content'] ?? [];

        $article = new Article();

        $article->uid = $this->uidFactory->createUid(new UidDetails($content['id'], ArticleSource::GUARDIAN));
        $article->title = $content['webTitle'];
        $article->link = $content['webUrl'];
        $article->publicationDate = DateTimeImmutable::createFromFormat(
            \DateTimeInterface::ISO8601,
            $content['webPublicationDate']
        );
        $article->source = ArticleSource::GUARDIAN;

        return $article;
    }
}
