<?php

namespace App\Domain\Specification;

interface CanAddCode
{
    public function isSatisfiedBy(string $code): bool;
}
