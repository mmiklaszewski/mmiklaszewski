<?php

namespace App\Infrastructure\EventListener;

use App\Domain\Event\CV\CVWasDownloaded;
use App\Domain\Event\Movie\MovieWasCreated;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: CVWasDownloaded::class, method: 'projectWhenCVWasDownloaded')]
#[AsEventListener(event: MovieWasCreated::class, method: 'projectWhenMovieWasCreated')]
final readonly class SlackListener
{
    public function __construct(
        private LoggerInterface $slackCVLogger,
        private LoggerInterface $slackMovieLogger
    ) {
    }

    #[NoReturn]
    public function projectWhenCVWasDownloaded(CVWasDownloaded $event): void
    {
        $this->slackCVLogger->info('cv_was_downloaded', $event->data);
    }

    #[NoReturn]
    public function projectWhenMovieWasCreated(MovieWasCreated $event): void
    {
        $this->slackMovieLogger->info('movie_was_created', [
            [
                'title' => $event->title,
                'code' => $event->code,
                'preferences' => $event->preferences,
            ],
        ]);
    }
}
