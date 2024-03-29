<?php

namespace App\Infrastructure\Projection;

use App\Domain\Event\Movie\AIReviewWasGenerated;
use App\Domain\Event\Movie\MovieDescriptionsWereCollected;
use App\Domain\Event\Movie\MovieDetailsWereCollected;
use App\Domain\Event\Movie\MoviePosterWasCollected;
use App\Domain\Event\Movie\MovieWasCreated;
use App\Domain\Event\Movie\MovieWhereWatchWereCollected;
use App\Domain\ReadModel\MovieReadModel;
use App\Infrastructure\Entity\Movie;
use App\Infrastructure\Repository\MovieRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: MovieWasCreated::class, method: 'projectWhenMovieWasCreated')]
#[AsEventListener(event: MovieDetailsWereCollected::class, method: 'projectWhenMovieDetailsWereCollected')]
#[AsEventListener(event: MovieDescriptionsWereCollected::class, method: 'projectWhenMovieDescriptionsWereCollected')]
#[AsEventListener(event: MoviePosterWasCollected::class, method: 'projectWhenMoviePosterWasCollected')]
#[AsEventListener(event: MovieWhereWatchWereCollected::class, method: 'projectWhenMovieWhereWatchWereCollected')]
#[AsEventListener(event: AIReviewWasGenerated::class, method: 'projectWhenAIReviewWasGenerated')]
final readonly class MovieProjection
{
    public function __construct(
        private MovieRepository $movieRepository,
        private MovieReadModel $movieReadModel
    ) {
    }

    #[NoReturn]
    public function projectWhenMovieWasCreated(MovieWasCreated $event): void
    {
        $entity = new Movie();
        $entity->setUuid($event->uuid);
        $entity->setTitle($event->title);
        $entity->setCategory($event->category->jsonSerialize());
        $entity->setPreferences($event->preferences);

        $this->movieRepository->save($entity);
    }

    #[NoReturn]
    public function projectWhenMovieDetailsWereCollected(MovieDetailsWereCollected $event): void
    {
        $entity = $this->movieReadModel->find($event->uuid);
        $entity->setDetailsLink($event->link->toString());
        $entity->setDetails($event->movieDetails->details);
        $this->movieRepository->save($entity);
    }

    #[NoReturn]
    public function projectWhenMovieDescriptionsWereCollected(MovieDescriptionsWereCollected $event): void
    {
        $entity = $this->movieReadModel->find($event->uuid);
        $entity->setDescriptionsLink($event->link->toString());
        $entity->setDescriptions($event->descriptionCollection->jsonSerialize());
        $this->movieRepository->save($entity);
    }

    #[NoReturn]
    public function projectWhenMoviePosterWasCollected(MoviePosterWasCollected $event): void
    {
        $entity = $this->movieReadModel->find($event->uuid);
        $entity->setPosterLink($event->link->toString());
        $this->movieRepository->save($entity);
    }

    #[NoReturn]
    public function projectWhenMovieWhereWatchWereCollected(MovieWhereWatchWereCollected $event): void
    {
        $entity = $this->movieReadModel->find($event->uuid);
        $entity->setWhereWatch($event->collection->jsonSerialize());
        $this->movieRepository->save($entity);
    }

    #[NoReturn]
    public function projectWhenAIReviewWasGenerated(AIReviewWasGenerated $event): void
    {
        $entity = $this->movieReadModel->find($event->uuid);
        $entity->setReview($event->review->jsonSerialize());
        $this->movieRepository->save($entity);
    }
}
