<?php

declare(strict_types=1);

namespace App\Manager;

use App\Enum\ArticleSource;
use App\Repository\ArticleRepositoryInterface;
use App\Repository\GuardianArticleRepository;

class ArticleRepositoryManager
{
    public function __construct(private readonly GuardianArticleRepository $guardian)
    {
    }

    /**
     * The purpose of this class is to allow for easy extension for new data sources
     * all of them will need to implement the @see \App\Repository\ArticleRepositoryInterface
     * once we add them, we won't need to change any other code
     *
     * @return ArticleRepositoryInterface[]
     */
    public function getAllRepositories(): array
    {
        return [
            $this->guardian
        ];
    }

    public function getRepositoriesByType(ArticleSource $type): ArticleRepositoryInterface
    {
        return match ($type) {
            ArticleSource::GUARDIAN => $this->guardian,
            //ArticleType::DATABASE => instance of database repo,
            default => throw new \Exception('incorrect article type'),
        };
    }
}
