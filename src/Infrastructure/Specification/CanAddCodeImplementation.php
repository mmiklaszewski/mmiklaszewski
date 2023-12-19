<?php

namespace App\Infrastructure\Specification;

use App\Domain\Specification\CanAddCode;
use App\Infrastructure\Repository\CodeRepository;

final readonly class CanAddCodeImplementation implements CanAddCode
{
    public function __construct(private CodeRepository $codeRepository)
    {
    }

    #[\Override]
    public function isSatisfiedBy(string $code): bool
    {
        return !$this->codeRepository->findOneBy(['code' => $code]);
    }
}
