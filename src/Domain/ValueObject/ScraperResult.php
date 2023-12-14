<?php

namespace App\Domain\ValueObject;

final readonly class ScraperResult
{
    public function __construct(
        public ?string $html = null,
    ) {
    }
}
