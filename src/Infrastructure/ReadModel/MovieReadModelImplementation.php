<?php

namespace App\Infrastructure\ReadModel;

use App\Domain\Exception\MovieNotFound;
use App\Domain\ReadModel\MovieReadModel;
use App\Infrastructure\Entity\Movie;
use App\Infrastructure\Repository\MovieRepository;
use Symfony\Component\Uid\Uuid;

final readonly class MovieReadModelImplementation implements MovieReadModel
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function find(Uuid $uuid): Movie
    {
        $entity = $this->movieRepository->findOneBy(['uuid' => $uuid]);
        if (!$entity) {
            throw MovieNotFound::create($uuid);
        }

        return $entity;
    }
}
