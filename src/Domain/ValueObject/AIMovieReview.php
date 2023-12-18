<?php

namespace App\Domain\ValueObject;

final readonly class AIMovieReview implements \JsonSerializable
{
    public function __construct(
        public ?string $description,
        public ?string $details,
        public ?string $preferences,
        public string $raw
    ) {
    }

    public static function fromString(string $raw): self
    {
        $data = json_decode($raw, true);

        $description = $data['description'] ?? null;
        $details = $data['details'] ?? null;
        $preferences = $data['preferences'] ?? null;

        return new self($description, $details, $preferences, $raw);
    }

    public static function fromArray(array $data): self
    {
        $description = $data['description'] ?? null;
        $details = $data['details'] ?? null;
        $preferences = $data['preferences'] ?? null;
        $raw = $data['raw'];

        return new self($description, $details, $preferences, $raw);
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'details' => $this->details,
            'preferences' => $this->preferences,
            'raw' => $this->raw,
        ];
    }
}
