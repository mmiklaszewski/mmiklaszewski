<?php

namespace App\Domain\Event\Movie;

use Symfony\Component\Uid\Uuid;

final readonly class MovieResultOpinionWasSaved
{
    public function __construct(
        public Uuid $uuid,
        public Uuid $movie,
        public string $opinion
    ) {
    }
}
