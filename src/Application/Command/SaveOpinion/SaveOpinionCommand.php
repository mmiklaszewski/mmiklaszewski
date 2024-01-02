<?php

namespace App\Application\Command\SaveOpinion;

use App\UI\Input\SaveOpinionInput;
use Symfony\Component\Uid\Uuid;

final readonly class SaveOpinionCommand
{
    public function __construct(
        public Uuid $uuid,
        public Uuid $movie,
        public string $opinion
    ) {
    }

    public static function fromInput(Uuid $uuid, SaveOpinionInput $input): self
    {
        return new self(
            $uuid,
            $input->movie,
            $input->opinion
        );
    }
}
