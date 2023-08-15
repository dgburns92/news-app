<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Article\SearchFilters;
use App\ApiResource\Article;

interface ArticleRepositoryInterface
{
    /** @return Article[] */
    public function search(SearchFilters $filters): array;

    public function findById(string $id): Article;
}
