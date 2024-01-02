<?php

namespace App\Application\Command\SaveOpinion;

use App\Domain\Event\Movie\MovieResultOpinionWasSaved;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SaveOpinionHandler
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
    ) {
    }

    public function __invoke(SaveOpinionCommand $command): void
    {
        $this->dispatcher->dispatch(
            new MovieResultOpinionWasSaved(
                $command->uuid,
                $command->movie,
                $command->opinion
            )
        );
    }
}
