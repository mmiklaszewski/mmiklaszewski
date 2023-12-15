<?php

namespace App\Domain\Collection;

use App\Domain\ValueObject\MovieDescription;
use Assert\Assertion;

final class MovieDescriptionCollection extends \ArrayIterator implements \JsonSerializable
{
    public function __construct(array $array = [])
    {
        Assertion::allIsInstanceOf($array, MovieDescription::class);
        parent::__construct($array);
    }

    public static function create(array $array = []): self
    {
        return new self($array);
    }

    public function append($value): void
    {
        Assertion::isInstanceOf($value, MovieDescription::class);
        parent::append($value);
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        $data = [];
        /** @var MovieDescription $description */
        foreach ($this as $description) {
            $data[] = $description->description;
        }

        return $data;
    }
}
