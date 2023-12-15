<?php

namespace App\Domain\Client;

use App\Domain\ValueObject\NetworkResult;

interface SearchInNetworkClient
{
    public function search(string $query): NetworkResult;
}
