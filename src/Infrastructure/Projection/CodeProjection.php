<?php

namespace App\Infrastructure\Projection;

use App\Domain\Event\Code\CodeWasCreated;
use App\Infrastructure\Entity\Code;
use App\Infrastructure\Repository\CodeRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: CodeWasCreated::class, method: 'projectWhenCodeWasCreated')]
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
}
