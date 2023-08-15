<?php

declare(strict_types=1);

namespace App\Dto\Article;

use App\Enum\ArticleSource;

class UidDetails
{
    public function __construct(
        public readonly string $id,
        public readonly ArticleSource $source,
    ) {
    }
}
