<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieDetails;

interface FindMovieDetails
{
    public function getDetails(Link $link): MovieDetails;
}
