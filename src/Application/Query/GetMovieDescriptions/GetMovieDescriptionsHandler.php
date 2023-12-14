<?php

namespace App\Application\Query\GetMovieDescriptions;

use App\Domain\Client\ScraperClient;
use App\Domain\Collection\MovieDescriptionCollection;
use App\Domain\ValueObject\MovieDescription;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetMovieDescriptionsHandler
{
    public function __construct(private ScraperClient $scraperClient)
    {
    }

    public function __invoke(GetMovieDescriptionsQuery $query): MovieDescriptionCollection
    {
        $result = $this->scraperClient->scrap($query->descriptionsLink);
        $descriptions = MovieDescriptionCollection::create();

        if (empty($result->html)) {
            return $descriptions;
        }

        $dom = \phpQuery::newDocument($result->html);

        $descriptionElements = $dom->find('div.descriptionSection__item');

        /** @var \DOMElement $descriptionElement */
        foreach ($descriptionElements as $descriptionElement) {
            if (empty($descriptionElement->nodeValue)) {
                continue;
            }
            $descriptions->append(MovieDescription::create($descriptionElement->nodeValue));
        }

        return $descriptions;
    }
}
