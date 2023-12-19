<?php

namespace App\Domain\Event\CV;

final readonly class CVWasDownloaded
{
    public function __construct(public array $data)
    {
    }
}
