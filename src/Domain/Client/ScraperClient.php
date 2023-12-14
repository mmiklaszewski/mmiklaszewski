<?php

namespace App\Domain\Client;

use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\ScraperResult;

interface ScraperClient
{
    public function scrap(Link $domain): ScraperResult;
}
