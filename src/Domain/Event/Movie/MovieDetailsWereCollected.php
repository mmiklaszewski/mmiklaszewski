<?php

namespace App\Domain\Event\Movie;

use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieDetails;
use Symfony\Component\Uid\Uuid;

final readonly class MovieDetailsWereCollected
{
    public function __construct(
        public Uuid $uuid,
        public Link $link,
        public MovieDetails $movieDetails
    ) {
    }
}
