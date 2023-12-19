<?php

namespace App\Domain\Event\Movie;

use App\Domain\Collection\MovieWhereWatchCollection;
use Symfony\Component\Uid\Uuid;

final class MovieWhereWatchWereCollected
{
    public function __construct(
        public Uuid $uuid,
        public MovieWhereWatchCollection $collection,
    ) {
    }
}
