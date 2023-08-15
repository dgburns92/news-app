<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Article\UidDetails;
use App\Enum\ArticleSource;

class UidFactory
{
    private const DELIMETER = '|||';

    public function createUid(UidDetails $details): string
    {
        $combinedDetails = sprintf('%s%s%s', $details->id, self::DELIMETER, $details->source->value);

        return base64_encode($combinedDetails);
    }

    public function extractDetailsFromUid(string $uid): UidDetails
    {
        $combinedDetails = base64_decode($uid);

        list($id, $source) = explode(self::DELIMETER, $combinedDetails, 2);

        return new UidDetails($id, ArticleSource::from($source));
    }
}
