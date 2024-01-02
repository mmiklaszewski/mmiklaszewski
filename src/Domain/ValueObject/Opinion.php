<?php

namespace App\Domain\ValueObject;

final class Opinion
{
    public function __construct(
        public string $opinion,
        public DateTime $createdAt
    ) {
    }

    public static function create(string $opinion, DateTime $created): self
    {
        return new self($opinion, $created);
    }
}
