<?php

namespace App\Domain\Event;

use App\Domain\ValueObject\Link;
use Symfony\Component\Uid\Uuid;

final class MoviePosterWasCollected
{
    public function __construct(
        public Uuid $uuid,
        public Link $link
    ) {
    }
}
