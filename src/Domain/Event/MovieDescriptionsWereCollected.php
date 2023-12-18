<?php

namespace App\Domain\Event;

use App\Domain\Collection\MovieDescriptionCollection;
use App\Domain\ValueObject\Link;
use Symfony\Component\Uid\Uuid;

final class MovieDescriptionsWereCollected
{
    public function __construct(
        public Uuid $uuid,
        public Link $link,
        public MovieDescriptionCollection $descriptionCollection,
    ) {
    }
}
