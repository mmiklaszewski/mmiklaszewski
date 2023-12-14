<?php

namespace App\Application\Query\GetMovieDescriptions;

use App\Domain\ValueObject\Link;

final readonly class GetMovieDescriptionsQuery
{
    public function __construct(public Link $descriptionsLink)
    {
    }
}
