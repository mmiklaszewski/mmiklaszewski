<?php

namespace App\Infrastructure\Projection;

use App\Domain\Event\Movie\MovieWasCreated;
use App\Infrastructure\Entity\CodeUsage;
use App\Infrastructure\Repository\CodeRepository;
use App\Infrastructure\Repository\CodeUsageRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: MovieWasCreated::class, method: 'projectWhenMovieWasCreated')]
final readonly class CodeUsageProjection
{
    public function __construct(private CodeUsageRepository $codeUsageRepository, private CodeRepository $codeRepository)
    {
    }

    #[NoReturn]
    public function projectWhenMovieWasCreated(MovieWasCreated $event): void
    {
        $code = $this->codeRepository->findOneBy(['code' => $event->code]);

        $entity = new CodeUsage();
        $entity->generateUuid();
        $entity->setCode($code->getUuid());
        $entity->setMovie($event->uuid);
        $this->codeUsageRepository->save($entity);
    }
}
