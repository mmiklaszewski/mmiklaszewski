<?php

namespace App\Infrastructure\Client;

use App\Domain\Client\ScraperClient;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\ScraperResult;
use GuzzleHttp\Client;

final class ScraperClientImplementation implements ScraperClient
{
    #[\Override]
    public function scrap(Link $domain): ScraperResult
    {
        $httpClient = new Client();
        $response = $httpClient->get($domain->toString());
        $htmlString = (string) $response->getBody();

        $htmlString = str_replace(["\u{A0}", "\u{200B}"], ' ', $htmlString);

        return new ScraperResult($htmlString);
    }
}
