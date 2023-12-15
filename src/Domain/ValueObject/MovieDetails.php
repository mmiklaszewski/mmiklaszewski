<?php

namespace App\Domain\ValueObject;

final class MovieDetails
{
    public function __construct(public array $details)
    {
    }
}
