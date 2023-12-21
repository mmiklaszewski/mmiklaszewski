<?php

namespace App\Infrastructure\Projection;

use App\Domain\Event\Code\CodeWasCreated;
use App\Domain\Event\Movie\MovieWasCreated;
use App\Infrastructure\Entity\Code;
use App\Infrastructure\Repository\CodeRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: CodeWasCreated::class, method: 'projectWhenCodeWasCreated')]
#[AsEventListener(event: MovieWasCreated::class, method: 'projectWhenMovieWasCreated')]
final readonly class CodeProjection
{
    public function __construct(private CodeRepository $codeRepository)
    {
    }

    #[NoReturn]
    public function projectWhenCodeWasCreated(CodeWasCreated $event): void
    {
        $entity = new Code();
        $entity->generateUuid();
        $entity->setCode($event->code);
        $entity->setLimit($event->limit);
        $entity->setUsed(0);

        $this->codeRepository->save($entity);
    }

    #[NoReturn]
    public function projectWhenMovieWasCreated(MovieWasCreated $event): void
    {
        $entity = $this->codeRepository->findOneBy(['code' => $event->code]);
        $entity->setUsed($entity->getUsed() + 1);
        $this->codeRepository->save($entity);
    }
}
