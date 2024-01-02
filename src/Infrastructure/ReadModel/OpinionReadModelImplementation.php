<?php

namespace App\Infrastructure\ReadModel;

use App\Domain\Collection\Opinions;
use App\Domain\ReadModel\OpinionReadModel;
use App\Domain\ValueObject\DateTime;
use App\Domain\ValueObject\Opinion;
use App\Infrastructure\Entity\Opinion as OpinionEntity;
use App\Infrastructure\Repository\OpinionRepository;
use Symfony\Component\Uid\Uuid;

final readonly class OpinionReadModelImplementation implements OpinionReadModel
{
    public function __construct(private OpinionRepository $opinionRepository)
    {
    }

    #[\Override]
    public function getOpinions(Uuid $movieResult): Opinions
    {
        $qb = $this->opinionRepository->createQueryBuilder('o');
        /** @var OpinionEntity[] $entities */
        $entities = $qb
            ->where('o.movie = :movie')
            ->orderBy('o.createdAt', 'DESC')
            ->setMaxResults('4')
            ->setParameter('movie', $movieResult)
            ->getQuery()
            ->getResult();

        $opinions = Opinions::create();
        foreach ($entities as $entity) {
            $opinions->append(
                Opinion::create(
                    $entity->getOpinion(),
                    DateTime::fromDateTime($entity->getCreatedAt())
                )
            );
        }

        return $opinions;
    }
}
