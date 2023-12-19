<?php

namespace App\Application\Command\CreateCode;

final readonly class CreateCodeCommand
{
    public function __construct(public string $code, public int $limit)
    {
    }
}
