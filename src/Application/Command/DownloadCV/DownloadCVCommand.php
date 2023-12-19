<?php

namespace App\Application\Command\DownloadCV;

final readonly class DownloadCVCommand
{
    public function __construct(public array $data)
    {
    }
}
