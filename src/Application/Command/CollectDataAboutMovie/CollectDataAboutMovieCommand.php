<?php

namespace App\Application\Command\CollectDataAboutMovie;

use App\Domain\ValueObject\MovieCategory;
use App\UI\Input\GenerateResponseAboutMovieInput;
use Symfony\Component\Uid\Uuid;

final readonly class CollectDataAboutMovieCommand
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public MovieCategory $category
    ) {
    }

    public static function fromInput(Uuid $uuid, GenerateResponseAboutMovieInput $input): self
    {
        return new self(
            $uuid,
            $input->title,
            MovieCategory::fromString($input->category)
        );

    }
}
