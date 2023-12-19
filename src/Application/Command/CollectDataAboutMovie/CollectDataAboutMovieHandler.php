<?php

namespace App\Application\Command\CollectDataAboutMovie;

use App\Domain\Event\Movie\MovieDescriptionsWereCollected;
use App\Domain\Event\Movie\MovieDetailsWereCollected;
use App\Domain\Event\Movie\MoviePosterWasCollected;
use App\Domain\Event\Movie\MovieWasCreated;
use App\Domain\Event\Movie\MovieWhereWatchWereCollected;
use App\Domain\Service\FindMovieDescriptions;
use App\Domain\Service\FindMovieDetails;
use App\Domain\Service\FindMovieDetailsLink;
use App\Domain\Service\FindMovieLink;
use App\Domain\Service\FindMoviePoster;
use App\Domain\Service\FindWhereWatchMovie;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CollectDataAboutMovieHandler
{
    public function __construct(
        private FindMovieDetailsLink $findMovieDetailsLink,
        private FindMovieDetails $findMovieDetails,
        private FindMovieLink $findMovieLink,
        private FindMovieDescriptions $findMovieDescriptions,
        private FindMoviePoster $findMoviePoster,
        private FindWhereWatchMovie $findWhereWatchMovie,
        private EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(CollectDataAboutMovieCommand $command): void
    {
        $this->dispatcher->dispatch(
            new MovieWasCreated($command->uuid, $command->title, $command->category, $command->preferences)
        );

        $wikiLink = $this->findMovieDetailsLink->search($command->title, $command->category);
        $details = $this->findMovieDetails->getDetails($wikiLink);

        $this->dispatcher->dispatch(
            new MovieDetailsWereCollected($command->uuid, $wikiLink, $details)
        );

        $filmWebLink = $this->findMovieLink->search($command->title, $command->category);
        $descriptions = $this->findMovieDescriptions->getDescriptions($filmWebLink);

        $this->dispatcher->dispatch(
            new MovieDescriptionsWereCollected($command->uuid, $filmWebLink, $descriptions)
        );

        $posterLink = $this->findMoviePoster->getPoster($filmWebLink);
        if (!empty($posterLink)) {
            $this->dispatcher->dispatch(
                new MoviePosterWasCollected($command->uuid, $posterLink)
            );
        }

        $whereWatch = $this->findWhereWatchMovie->findWhereWatch($filmWebLink);
        $this->dispatcher->dispatch(
            new MovieWhereWatchWereCollected(
                $command->uuid,
                $whereWatch
            )
        );
    }
}
