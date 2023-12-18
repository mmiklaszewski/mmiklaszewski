<?php

namespace App\Domain\ValueObject\AI;

final readonly class Message
{
    public function __construct(public Role $role, public string $content)
    {
    }
}
