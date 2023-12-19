<?php

namespace App\Domain\Collection;

use App\Domain\ValueObject\MovieWhereWatch;
use Assert\Assertion;

final class MovieWhereWatchCollection extends \ArrayIterator implements \JsonSerializable
{
    public function __construct(array $array = [])
    {
        Assertion::allIsInstanceOf($array, MovieWhereWatch::class);
        parent::__construct($array);
    }

    public static function fromArray(array $data): self
    {
        $self = new self();
        foreach ($data as $itemData) {
            $self->append(
                MovieWhereWatch::fromArray($itemData)
            );
        }

        return $self;
    }

    public static function create(array $array = []): self
    {
        return new self($array);
    }

    public function append($value): void
    {
        Assertion::isInstanceOf($value, MovieWhereWatch::class);
        parent::append($value);
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        $data = [];
        /** @var MovieWhereWatch $item */
        foreach ($this as $item) {
            $data[] = $item->jsonSerialize();
        }

        return $data;
    }
}
