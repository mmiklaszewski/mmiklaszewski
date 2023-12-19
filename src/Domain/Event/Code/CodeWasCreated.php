<?php

namespace App\Domain\Event\Code;

final readonly class CodeWasCreated
{
    public function __construct(public string $code, public int $limit)
    {
    }
}
