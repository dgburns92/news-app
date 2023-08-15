<?php

declare(strict_types=1);

namespace App\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Article\SearchFilters;
use App\ApiResource\Article;
use App\Enum\ArticleSource;
use App\Factory\UidFactory;
use App\Manager\ArticleRepositoryManager;

/** @implements ProviderInterface<Article> */
final class ArticleProvider implements ProviderInterface
{
    public function __construct(
        private readonly UidFactory $uidFactory,
        private readonly ArticleRepositoryManager $manager
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Article
    {
        $uidDetails = $this->uidFactory->extractDetailsFromUid($uriVariables['uid']);

        $repo = $this->manager->getRepositoriesByType($uidDetails->source);

        return $repo->findById($uidDetails->id);
    }
}
