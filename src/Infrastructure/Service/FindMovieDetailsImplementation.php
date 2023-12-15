<?php

namespace App\Infrastructure\Service;

use App\Domain\Client\ScraperClient;
use App\Domain\Service\FindMovieDetails;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieDetails;

final readonly class FindMovieDetailsImplementation implements FindMovieDetails
{
    public function __construct(private ScraperClient $scraperClient)
    {
    }

    #[\Override]
    public function getDetails(Link $link): MovieDetails
    {
        $result = $this->scraperClient->scrap($link);
        $dom = \phpQuery::newDocument($result->html);

        $details = $dom->find('.infobox');

        $html = $details->html();
        $pattern = '/<tr(.*?)<\/tr>/s';
        preg_match_all($pattern, $html, $matches);

        $movieDetails = [];

        foreach ($matches[0] as $match) {
            $pattern = '/(<a[^>]*>)([^<]+)(<\/a>)/';
            $replacement = '$1$2 $3';

            $match = preg_replace($pattern, $replacement, $match);

            $match = str_replace('<br>', ' ', $match);

            $data = \phpQuery::newDocument($match);

            /** @var ?\DOMElement $th */
            $th = $data->find('th')->elements[0] ?? null;
            /** @var ?\DOMElement $td */
            $td = $data->find('td')->elements[0] ?? null;

            if (empty($th) || empty($td)) {
                continue;
            }

            $thValue = trim(str_replace("\n", '', $th->nodeValue));
            $tdValue = trim(str_replace("\n", '', $td->nodeValue));

            $thValue = str_replace(["\u{A0}", "\u{200B}"], ' ', $thValue);
            $tdValue = str_replace(["\u{A0}", "\u{200B}"], ' ', $tdValue);
            $movieDetails[$thValue] = $tdValue;
        }

        return new MovieDetails($movieDetails);
    }
}
