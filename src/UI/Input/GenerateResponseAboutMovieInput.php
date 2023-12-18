<?php

namespace App\UI\Input;

use App\Domain\ValueObject\MovieCategory;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class GenerateResponseAboutMovieInput
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 100)]
        public string $title,

        #[Assert\NotBlank]
        #[Assert\Choice(callback: [MovieCategory::class, 'available'])]
        public string $category,

        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 300)]
        public string $preferences
    ) {
    }
}
