<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;

final readonly class MovieWhereWatch implements \JsonSerializable
{
    public function __construct(public Link $logo, public string $name, public Link $movieUrl)
    {
    }

    public static function fromArray(array $data): self
    {
        Assertion::keyExists($data, 'logo');
        Assertion::keyExists($data, 'name');
        Assertion::keyExists($data, 'movieUrl');
        return new self(
            Link::fromString($data['logo']),
            $data['name'],
            Link::fromString($data['movieUrl']),
        );

    }

    #[\Override]
    public function jsonSerialize(): array
    {
        return [
            'logo' => $this->logo->toString(),
            'name' => $this->name,
            'movieUrl' => $this->movieUrl->toString(),
        ];
    }
}
