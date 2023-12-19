<?php

namespace App\Domain\Service;

use App\Domain\Collection\MovieWhereWatchCollection;
use App\Domain\ValueObject\Link;

interface FindWhereWatchMovie
{
    public function findWhereWatch(Link $link): MovieWhereWatchCollection;
}
