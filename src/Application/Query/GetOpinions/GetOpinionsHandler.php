<?php

namespace App\Application\Query\GetOpinions;

use App\Domain\ReadModel\OpinionReadModel;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetOpinionsHandler
{
    public function __construct(private OpinionReadModel $opinionReadModel)
    {
    }

    public function __invoke(GetOpinionsQuery $query): OpinionsView
    {
        $opinions = $this->opinionReadModel->getOpinions($query->movieResult);

        return OpinionsView::create($opinions);
    }
}
