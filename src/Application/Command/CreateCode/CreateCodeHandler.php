<?php

namespace App\Application\Command\CreateCode;

use App\Domain\Event\Code\CodeWasCreated;
use App\Domain\Exception\CanNotAddCode;
use App\Domain\Specification\CanAddCode;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateCodeHandler
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private CanAddCode $canAddCode
    ) {
    }

    public function __invoke(CreateCodeCommand $command): void
    {
        if (!$this->canAddCode->isSatisfiedBy($command->code)) {
            throw CanNotAddCode::create($command->code);
        }

        $this->dispatcher->dispatch(
            new CodeWasCreated(
                $command->code,
                $command->limit
            )
        );
    }
}
