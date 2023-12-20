<?php

namespace App\Infrastructure\Service;

use App\Domain\Collection\MovieWhereWatchCollection;
use App\Domain\Service\FindWhereWatchMovie;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieWhereWatch;
use GuzzleHttp\Client;

final readonly class FindWhereWatchMovieImplementation implements FindWhereWatchMovie
{
    public function __construct()
    {
    }

    public function findWhereWatch(Link $link): MovieWhereWatchCollection
    {
        $parts = explode('-', $link->toString());

        $collection = MovieWhereWatchCollection::create();
        $id = end($parts);

        if (empty($id) || !is_numeric($id)) {
            return $collection;
        }

        $movieProvidersUrl = sprintf('https://www.filmweb.pl/api/v1/vod/film/%s/providers/list', $id);

        $allProvidersUrl = 'https://www.filmweb.pl/api/v1/vod/providers/list';

        $httpClient = new Client();

        $movieProviders = json_decode($httpClient->get($movieProvidersUrl)->getBody()->getContents(), true);
        $allProviders = json_decode($httpClient->get($allProvidersUrl)->getBody()->getContents(), true);

        foreach ($movieProviders as $movieProvider) {
            foreach ($allProviders as $allProvider) {
                if ($movieProvider['vodProvider'] === $allProvider['id']) {
                    $whereWatch = new MovieWhereWatch(
                        Link::fromString(sprintf('https://fwcdn.pl/vodp%s', str_replace('$', 1, $allProvider['path']))),
                        $allProvider['displayName'],
                        Link::fromString($movieProvider['link'])
                    );

                    $collection->append($whereWatch);
                }
            }
        }

        return $collection;
    }
}
