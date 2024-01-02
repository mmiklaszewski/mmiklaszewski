<?php

namespace App\Domain\Collection;

use App\Domain\ValueObject\Opinion;
use Assert\Assertion;

final class Opinions extends \ArrayIterator
{
    public function __construct(array $array = [])
    {
        Assertion::allIsInstanceOf($array, Opinion::class);
        parent::__construct($array);
    }

    public static function create(array $array = []): self
    {
        return new self($array);
    }

    public function append($value): void
    {
        Assertion::isInstanceOf($value, Opinion::class);
        parent::append($value);
    }
}
