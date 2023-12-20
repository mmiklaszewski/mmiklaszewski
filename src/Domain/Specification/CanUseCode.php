<?php

namespace App\Domain\Specification;

interface CanUseCode
{
    public function isSatisfiedBy(string $code): bool;
}
