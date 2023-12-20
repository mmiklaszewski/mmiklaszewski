<?php

namespace App\Infrastructure\ReadModel;

use App\Domain\Exception\CodeNotFound;
use App\Domain\ReadModel\CodeReadModel;
use App\Infrastructure\Entity\Code;
use App\Infrastructure\Repository\CodeRepository;

final readonly class CodeReadModelImplementation implements CodeReadModel
{
    public function __construct(private CodeRepository $codeRepository)
    {
    }

    #[\Override]
    public function find(string $code): Code
    {
        $codeEntity = $this->codeRepository->findOneBy(['code' => $code]);
        if (!$codeEntity) {
            throw CodeNotFound::create($code);
        }

        return $codeEntity;
    }
}
