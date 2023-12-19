<?php

namespace App\Domain\Event;

final readonly class CVWasDownloaded
{
    public function __construct(public array $data)
    {
    }
}
