<?php

namespace App\Infrastructure\Service;

use App\Domain\Client\SearchInNetworkClient;
use App\Domain\Exception\MovieLinkNotFound;
use App\Domain\Service\FindMovieLink;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieCategory;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class FindMovieLinkImplementation implements FindMovieLink
{
    public function __construct(private SearchInNetworkClient $client, private TranslatorInterface $translator)
    {
    }

    #[\Override]
    public function search(string $title, MovieCategory $category): Link
    {
        $query = sprintf(
            'site:filmweb.pl %s (%s)',
            $title,
            $this->translator->trans(sprintf('movieCategory.%s', $category->jsonSerialize()), [], 'app')
        );

        $result = $this->client->search($query);

        $link = $result->data['organic'][0]['link'] ?? null;

        if (empty($link)) {
            throw MovieLinkNotFound::create($title);
        }

        $link = $this->prepareLink($link, $title, $category);

        return Link::fromString($link);
    }

    private function prepareLink(string $link, string $title, MovieCategory $category): string
    {
        $linkVO = Link::fromString($link);

        $type = $category->equal(MovieCategory::movie()) ? 'film' : 'serial';

        $arguments = str_replace(
            sprintf(
                '%s://%s/%s/',
                $linkVO->scheme(),
                $linkVO->host(),
                $type
            ),
            '',
            $link
        );

        $movieTitle = explode('/', $arguments)[0] ?? null;

        if (!$movieTitle) {
            throw MovieLinkNotFound::create($title);
        }

        return sprintf('%s://%s/%s/%s', $linkVO->scheme(), $linkVO->host(), $type, $movieTitle);
    }
}
