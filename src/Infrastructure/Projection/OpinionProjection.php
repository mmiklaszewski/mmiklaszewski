<?php

namespace App\Infrastructure\Projection;

use App\Domain\Event\Movie\MovieResultOpinionWasSaved;
use App\Infrastructure\Entity\Opinion;
use App\Infrastructure\Repository\OpinionRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: MovieResultOpinionWasSaved::class, method: 'projectWhenMovieResultOpinionWasSaved')]
final readonly class OpinionProjection
{
    public function __construct(private OpinionRepository $opinionRepository)
    {
    }

    #[NoReturn]
    public function projectWhenMovieResultOpinionWasSaved(MovieResultOpinionWasSaved $event): void
    {
        $opinion = new Opinion();
        $opinion->setUuid($event->uuid);
        $opinion->setMovie($event->movie);
        $opinion->setOpinion($event->opinion);

        $this->opinionRepository->save($opinion);
    }
}
