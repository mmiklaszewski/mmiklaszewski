<?php

namespace App\Domain\ReadModel;

use App\Infrastructure\Entity\Movie;
use Symfony\Component\Uid\Uuid;

interface MovieReadModel
{
    public function find(Uuid $uuid): Movie;
}
