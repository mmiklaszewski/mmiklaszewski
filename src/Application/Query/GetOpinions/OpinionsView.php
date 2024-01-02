<?php

namespace App\Application\Query\GetOpinions;

use App\Domain\Collection\Opinions;
use App\Domain\ValueObject\Opinion;

final readonly class OpinionsView implements \JsonSerializable
{
    public function __construct(private Opinions $opinions)
    {
    }

    public static function create(Opinions $opinions): self
    {
        return new self($opinions);
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        $data = [];
        /** @var Opinion $opinion */
        foreach ($this->opinions as $opinion) {
            $data[] = [
                'opinion' => $opinion->opinion,
                'createdAt' => $opinion->createdAt->toString(),
            ];
        }

        return $data;
    }
}
