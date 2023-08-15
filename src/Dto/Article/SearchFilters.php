<?php

declare(strict_types=1);

namespace App\Dto\Article;

/**
 * This class should contain all filters that a user would search on,
 * currently it is just keyword, but you could add other filters like:
 * - publicationDate
 * - article source
 * - page
 */
class SearchFilters
{
    public function __construct(public readonly ?string $keyword)
    {
    }
}
