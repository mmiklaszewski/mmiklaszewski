<?php

namespace App\UI\Input;

use App\Domain\ValueObject\MovieCategory;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class ResultAboutMovieInput
{
    public function __construct(
        #[Assert\NotBlank]
        public string $responseUuid,
    ) {
    }
}
