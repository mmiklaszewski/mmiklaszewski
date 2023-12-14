<?php

namespace App\Domain\ValueObject;

final readonly class MovieDescription
{
    public function __construct(public string $description)
    {
    }

    public static function create(string $description): self
    {
        return new self($description);
    }
}
