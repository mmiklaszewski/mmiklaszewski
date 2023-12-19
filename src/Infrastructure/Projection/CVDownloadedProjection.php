<?php

namespace App\Infrastructure\Projection;

use App\Domain\Event\CVWasDownloaded;
use App\Infrastructure\Entity\CVDownloaded;
use App\Infrastructure\Repository\CVDownloadedRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: CVWasDownloaded::class, method: 'projectWhenCVWasDownloaded')]
final readonly class CVDownloadedProjection
{
    public function __construct(private CVDownloadedRepository $CVDownloadedRepository)
    {
    }

    #[NoReturn]
    public function projectWhenCVWasDownloaded(CVWasDownloaded $event): void
    {
        $entity = new CVDownloaded();
        $entity->setRequestData($event->data);
        $this->CVDownloadedRepository->save($entity);
    }
}
