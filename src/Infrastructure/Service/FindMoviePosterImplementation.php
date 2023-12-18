<?php

namespace App\Infrastructure\Service;

use App\Domain\Client\ScraperClient;
use App\Domain\Service\FindMoviePoster;
use App\Domain\ValueObject\Link;

final readonly class FindMoviePosterImplementation implements FindMoviePoster
{
    public function __construct(private ScraperClient $scraperClient)
    {
    }

    #[\Override]
    public function getPoster(Link $link): ?Link
    {
        $result = $this->scraperClient->scrap($link);

        if (empty($result->html)) {
            return null;
        }

        $dom = \phpQuery::newDocument($result->html);

        $poster = $dom->find('#filmPoster');

        $src = pq($poster)->attr('src');
        if (empty($src)) {
            return null;
        }

        try {
            return Link::fromString($src);
        } catch (\Throwable $throwable) {
            return null;
        }
    }
}
