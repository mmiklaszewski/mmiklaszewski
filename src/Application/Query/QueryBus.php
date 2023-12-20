<?php

namespace App\Application\Query;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class QueryBus implements MessageBusInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function handle(mixed $query): mixed
    {
        try {
            return $this->dispatch($query)->last(HandledStamp::class)->getResult();
        } catch (\Exception $exception) {
            if ($exception->getPrevious()) {
                throw $exception->getPrevious();
            }
            throw $exception;
        }
    }

    public function dispatch(object $message, array $stamps = []): Envelope
    {
        return $this->bus->dispatch($message, $stamps);
    }
}
