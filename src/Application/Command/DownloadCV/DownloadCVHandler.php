<?php

namespace App\Application\Command\DownloadCV;

use App\Domain\Event\CVWasDownloaded;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DownloadCVHandler
{
    public function __construct(private EventDispatcherInterface $dispatcher)
    {
    }

    public function __invoke(DownloadCVCommand $command): void
    {
        $this->dispatcher->dispatch(
            new CVWasDownloaded(
                $command->data
            )
        );
    }
}
