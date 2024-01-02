<?php

namespace App\Application\Query\GetOpinions;

use Symfony\Component\Uid\Uuid;

final readonly class GetOpinionsQuery
{
    public function __construct(public Uuid $movieResult)
    {
    }
}
