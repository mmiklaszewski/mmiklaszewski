<?php

namespace App\Domain\ValueObject\AI;

use Assert\Assertion;

final readonly class Role
{
    private const USER = 'user';

    private const SYSTEM = 'system';

    public function __construct(private string $role)
    {
        Assertion::inArray($role, (new \ReflectionClass(self::class))->getConstants());
    }

    public static function fromString(string $role): self
    {
        return new self($role);
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    public static function system(): self
    {
        return new self(self::SYSTEM);
    }

    public function jsonSerialize(): string
    {
        return $this->role;
    }
}
