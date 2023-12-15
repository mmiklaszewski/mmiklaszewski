<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;

final readonly class MovieCategory implements \JsonSerializable
{
    private const MOVIE = 'movie';
    private const SERIES = 'series';
    private string $category;

    public function __construct(string $category)
    {
        Assertion::inArray($category, (new \ReflectionClass(self::class))->getConstants());
        $this->category = $category;
    }

    public static function fromString(string $category): self
    {
        return new self($category);
    }

    public static function movie(): self
    {
        return new self(self::MOVIE);
    }

    public static function series(): self
    {
        return new self(self::SERIES);
    }

    #[\Override]
    public function jsonSerialize(): string
    {
        return $this->category;
    }
}
