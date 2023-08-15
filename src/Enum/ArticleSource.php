<?php

declare(strict_types=1);

namespace App\Enum;

enum ArticleSource: string
{
    case GUARDIAN = 'guardian';
    case THE_AGE = 'the age';
    case DATABASE = 'database';
}
