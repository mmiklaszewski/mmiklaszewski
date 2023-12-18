<?php

namespace App\Application\Query\GetResult;

use Symfony\Component\Uid\Uuid;

final readonly class GetResultQuery
{
    public function __construct(public Uuid $resultUuid)
    {
    }
}
