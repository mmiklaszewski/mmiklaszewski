<?php

namespace App\Application\Query\GetResult;

use App\Domain\ValueObject\MovieCategory;
use App\Infrastructure\Entity\Movie;
use Symfony\Component\Uid\Uuid;

final readonly class ResultView implements \JsonSerializable
{
    public function __construct(
        public Uuid $resultUuid,
        public string $title,
        public MovieCategory $category
    )
    {
    }

    public static function fromEntity(Movie $movie): self
    {
        return new self(
            $movie->getUuid(),
            mb_convert_case($movie->getTitle(), MB_CASE_TITLE),
            MovieCategory::fromString($movie->getCategory())
        );
    }

    #[\Override] public function jsonSerialize(): array
    {
        return [
            'resultUuid' => $this->resultUuid->jsonSerialize(),
            'title' => $this->title,
            'category' => $this->category->jsonSerialize()
        ];
    }
}