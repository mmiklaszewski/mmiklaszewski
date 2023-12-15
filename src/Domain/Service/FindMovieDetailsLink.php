<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieCategory;

interface FindMovieDetailsLink
{
    public function search(string $title, MovieCategory $category): Link;
}
