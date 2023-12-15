<?php

namespace App\Application\Command\CollectDataAboutMovie;

use App\Domain\ValueObject\MovieCategory;
use Symfony\Component\Uid\Uuid;

final readonly class CollectDataAboutMovieCommand
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public MovieCategory $category
    ) {
    }
}
