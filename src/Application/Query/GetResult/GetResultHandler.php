<?php

namespace App\Application\Query\GetResult;

use App\Domain\ReadModel\MovieReadModel;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetResultHandler
{
    public function __construct(private MovieReadModel $movieReadModel)
    {
    }

    public function __invoke(GetResultQuery $query): ResultView
    {
        $entity = $this->movieReadModel->find($query->resultUuid);

        return ResultView::fromEntity($entity);

    }

}