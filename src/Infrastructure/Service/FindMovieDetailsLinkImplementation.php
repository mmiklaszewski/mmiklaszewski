<?php

namespace App\Infrastructure\Service;

use App\Domain\Client\SearchInNetworkClient;
use App\Domain\Exception\MovieLinkNotFound;
use App\Domain\Service\FindMovieDetailsLink;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieCategory;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class FindMovieDetailsLinkImplementation implements FindMovieDetailsLink
{
    public function __construct(private SearchInNetworkClient $client, private TranslatorInterface $translator)
    {
    }

    #[\Override]
    public function search(string $title, MovieCategory $category): Link
    {
        $query = sprintf(
            'site:wikipedia.org %s (%s)',
            $title,
            $this->translator->trans(sprintf('movieCategory.%s', $category->jsonSerialize()), [], 'app')
        );

        $result = $this->client->search($query);

        $link = $result->data['organic'][0]['link'] ?? null;

        if (empty($link)) {
            throw MovieLinkNotFound::create($title);
        }

        return Link::fromString($link);
    }
}
