<?php

declare(strict_types=1);

namespace App\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Article\SearchFilters;
use App\ApiResource\Article;
use App\Manager\ArticleRepositoryManager;

/** @implements ProviderInterface<Article> */
final class ArticleCollectionProvider implements ProviderInterface
{
    public function __construct(private readonly ArticleRepositoryManager $manager)
    {
    }

    /** @return Article[] */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $filters = new SearchFilters(keyword: $context['filters']['keyword'] ?? null);

        $articles = [];

        foreach ($this->manager->getAllRepositories() as $repo) {
            $articles = array_merge($articles, $repo->search($filters));
        }

        return $articles;
    }
}
