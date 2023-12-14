<?php

namespace App\Infrastructure\Client;

use App\Domain\Client\ScraperClient;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\ScraperResult;
use GuzzleHttp\Client;

final class ScraperClientImplementation implements ScraperClient
{
    public function scrap(Link $domain): ScraperResult
    {
        $httpClient = new Client();
        $response = $httpClient->get($domain->toString());
        $htmlString = (string) $response->getBody();

        return new ScraperResult($htmlString);
    }

    // todo remove
    public function clearHtml(string $html): string
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.AllowedElements', [
            'a',
        ]);
        $config->set('HTML.AllowedAttributes', [
            'a.href',
        ]);
        $config->set('CSS.AllowedProperties', [
        ]);
        $config->set('URI.AllowedSchemes', [
            'data' => true,
            'http' => true,
            'https' => true,
            'mailto' => true,
            'ftp' => true,
            'tel' => true,
        ]);
        $def = $config->getHTMLDefinition(true);
        $def->addAttribute('td', 'border', 'Number');
        $purifier = new \HTMLPurifier($config);

        $html = $purifier->purify($html);

        $html = str_replace(["\n", "\t"], '', $html);

        $html = str_replace(["\u{A0}", "\u{200B}"], ' ', $html);

        $html = preg_replace('/\s+/', ' ', $html);

        return $html;
    }
}
