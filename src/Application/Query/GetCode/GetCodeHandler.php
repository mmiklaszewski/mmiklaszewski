<?php

namespace App\Application\Query\GetCode;

use App\Domain\ReadModel\CodeReadModel;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetCodeHandler
{
    public function __construct(private CodeReadModel $codeReadModel)
    {
    }

    public function __invoke(GetCodeQuery $query): CodeView
    {
        $code = $this->codeReadModel->find($query->code);

        return CodeView::fromEntity($code);
    }
}
