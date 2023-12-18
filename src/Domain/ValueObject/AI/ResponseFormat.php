<?php

namespace App\Domain\ValueObject\AI;

use Assert\Assertion;

final class ResponseFormat implements \JsonSerializable
{
    private const JSON = 'json_object';
    private const TEXT = 'text';
    private string $format;

    public function __construct(string $format)
    {
        Assertion::inArray($format, (new \ReflectionClass(self::class))->getConstants());
        $this->format = $format;
    }

    public static function json(): self
    {
        return new self(self::JSON);
    }

    public static function text(): self
    {
        return new self(self::TEXT);
    }

    public function jsonSerialize(): string
    {
        return $this->format;
    }
}
