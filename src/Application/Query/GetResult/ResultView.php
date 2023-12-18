<?php

namespace App\Application\Query\GetResult;

use App\Domain\ValueObject\AIMovieReview;
use App\Domain\ValueObject\Link;
use App\Domain\ValueObject\MovieCategory;
use App\Infrastructure\Entity\Movie;
use Symfony\Component\Uid\Uuid;

final readonly class ResultView implements \JsonSerializable
{
    public function __construct(
        public Uuid $resultUuid,
        public string $title,
        public MovieCategory $category,
        public ?string $description,
        public ?string $details,
        public string $preferences,
        public ?Link $poster,
    ) {
    }

    public static function fromEntity(Movie $movie): self
    {
        $review = AIMovieReview::fromArray($movie->getReview() ?? []);

        return new self(
            $movie->getUuid(),
            mb_convert_case($movie->getTitle(), MB_CASE_TITLE),
            MovieCategory::fromString($movie->getCategory()),
            $review->description,
            $review->details,
            $review->preferences,
            $movie->getPosterLink() ? Link::fromString($movie->getPosterLink()) : null
        );
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        return [
            'resultUuid' => $this->resultUuid->jsonSerialize(),
            'title' => $this->title,
            'category' => $this->category->jsonSerialize(),
            'description' => $this->description,
            'details' => $this->details,
            'preferences' => $this->preferences,
            'poster' => $this->poster?->toString(),
        ];
    }
}
