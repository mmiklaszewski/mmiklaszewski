<?php

namespace App\Domain\Event;

use App\Domain\ValueObject\MovieCategory;
use Symfony\Component\Uid\Uuid;

final readonly class MovieWasCreated
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public MovieCategory $category,
        public string $preferences
    ) {
    }
}
