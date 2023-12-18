<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\Link;

interface FindMoviePoster
{
    public function getPoster(Link $link): ?Link;
}
