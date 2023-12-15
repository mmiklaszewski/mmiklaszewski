<?php

namespace App\Domain\ValueObject;

final class NetworkResult
{
    public function __construct(public array $data)
    {
    }
}
