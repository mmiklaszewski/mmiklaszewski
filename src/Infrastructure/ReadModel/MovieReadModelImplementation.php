<?php

namespace App\Infrastructure\ReadModel;

use App\Domain\ReadModel\MovieReadModel;
use App\Repository\MovieRepository;

final readonly class MovieReadModelImplementation implements MovieReadModel
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }
}
