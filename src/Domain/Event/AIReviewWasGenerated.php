<?php

namespace App\Domain\Event;

use App\Domain\ValueObject\AIMovieReview;
use Symfony\Component\Uid\Uuid;

final readonly class AIReviewWasGenerated
{
    public function __construct(public Uuid $uuid, public AIMovieReview $review)
    {
    }
}
