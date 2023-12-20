<?php

namespace App\Infrastructure\Specification;

use App\Application\Query\GetCode\CodeView;
use App\Application\Query\GetCode\GetCodeQuery;
use App\Application\Query\QueryBus;
use App\Domain\Exception\CodeWasUsed;
use App\Domain\Specification\CanUseCode;

final readonly class CanUseCodeImplementation implements CanUseCode
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    #[\Override]
    public function isSatisfiedBy(string $code): bool
    {
        /** @var CodeView $codeView */
        $codeView = $this->queryBus->handle(new GetCodeQuery(
            $code
        ));

        if ($codeView->isUsed()) {
            throw CodeWasUsed::create($code);
        }

        return true;
    }
}
