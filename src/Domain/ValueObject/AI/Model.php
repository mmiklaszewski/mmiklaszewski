<?php

namespace App\Domain\ValueObject\AI;

use Assert\Assertion;

final readonly class Model implements \JsonSerializable
{
    private const GPT_3_5_turbo = 'gpt-3.5-turbo-1106';
    private const GPT_4_turbo = 'gpt-4-1106-preview';

    public function __construct(private string $model)
    {
        Assertion::inArray($model, (new \ReflectionClass(self::class))->getConstants());
    }

    public static function fromString(string $string): self
    {
        return new self($string);
    }

    public static function gpt3_5_turbo(): self
    {
        return new self(self::GPT_3_5_turbo);
    }

    public static function gpt4_turbo(): self
    {
        return new self(self::GPT_4_turbo);
    }

    public function jsonSerialize(): string
    {
        return $this->model;
    }
}
