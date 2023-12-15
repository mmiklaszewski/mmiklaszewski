<?php

namespace App\Domain\Service;

use App\Domain\Collection\MovieDescriptionCollection;
use App\Domain\ValueObject\Link;

interface FindMovieDescriptions
{
    public function getDescriptions(Link $link): MovieDescriptionCollection;
}
