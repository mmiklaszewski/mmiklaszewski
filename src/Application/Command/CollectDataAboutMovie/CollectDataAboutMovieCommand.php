<?php

namespace App\Application\Command\CollectDataAboutMovie;

use App\Domain\ValueObject\MovieCategory;
use App\UI\Input\GenerateResponseAboutMovieInput;
use Symfony\Component\Uid\Uuid;

final readonly class CollectDataAboutMovieCommand
{
    public function __construct(
        public string $code,
        public Uuid $uuid,
        public string $title,
        public MovieCategory $category,
        public string $preferences
    ) {
    }

    public static function fromInput(Uuid $uuid, GenerateResponseAboutMovieInput $input, string $code): self
    {
        return new self(
            $code,
            $uuid,
            $input->title,
            MovieCategory::fromString($input->category),
            $input->preferences
        );
    }
}
