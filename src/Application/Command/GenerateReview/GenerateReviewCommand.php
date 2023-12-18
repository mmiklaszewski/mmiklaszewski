<?php

namespace App\Application\Command\GenerateReview;

use Symfony\Component\Uid\Uuid;

final class GenerateReviewCommand
{
    public function __construct(public Uuid $movie)
    {
    }
}
