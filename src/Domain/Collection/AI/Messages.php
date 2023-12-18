<?php

namespace App\Domain\Collection\AI;

use App\Domain\ValueObject\AI\Message;
use Assert\Assertion;

final class Messages extends \ArrayIterator implements \JsonSerializable
{
    public function __construct(array $array = [])
    {
        Assertion::allIsInstanceOf($array, Message::class);
        parent::__construct($array);
    }

    public static function create(array $array = []): self
    {
        return new self($array);
    }

    public function append($value): void
    {
        Assertion::isInstanceOf($value, Message::class);
        parent::append($value);
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        $data = [];
        /** @var Message $message */
        foreach ($this as $message) {
            $data[] = [
                'role' => $message->role->jsonSerialize(),
                'content' => $message->content,
            ];
        }

        return $data;
    }
}
