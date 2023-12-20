<?php

namespace App\Application\Query\GetCode;

final readonly class GetCodeQuery
{
    public function __construct(public string $code)
    {
    }
}
