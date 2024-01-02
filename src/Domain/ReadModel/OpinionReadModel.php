<?php

namespace App\Domain\ReadModel;

use App\Domain\Collection\Opinions;
use Symfony\Component\Uid\Uuid;

interface OpinionReadModel
{
    public function getOpinions(Uuid $movieResult): Opinions;
}
