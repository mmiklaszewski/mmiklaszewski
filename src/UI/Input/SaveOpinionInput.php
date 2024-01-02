<?php

namespace App\UI\Input;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveOpinionInput
{
    public function __construct(
        #[Assert\Uuid]
        public Uuid $movie,

        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 400)]
        public string $opinion,
    ) {
    }
}
