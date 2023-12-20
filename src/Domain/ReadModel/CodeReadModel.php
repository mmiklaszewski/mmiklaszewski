<?php

namespace App\Domain\ReadModel;

use App\Infrastructure\Entity\Code;

interface CodeReadModel
{
    public function find(string $code): Code;
}
