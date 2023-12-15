<?php

namespace App\Infrastructure\Service;

use App\Domain\Client\ScraperClient;
use App\Domain\Collection\MovieDescriptionCollection;
use App\Domain\Service\FindMovieDescriptions;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieDescription;

final readonly class FindMovieDescriptionsImplementation implements FindMovieDescriptions
{
    public function __construct(private ScraperClient $scraperClient)
    {
    }

    #[\Override]
    public function getDescriptions(Link $link): MovieDescriptionCollection
    {
        $link = Link::fromString(sprintf('%s/descs', $link->toString()));
        $result = $this->scraperClient->scrap($link);
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
