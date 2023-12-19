<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\CodeUsage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodeUsage>
 *
 * @method CodeUsage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodeUsage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodeUsage[]    findAll()
 * @method CodeUsage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CodeUsageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodeUsage::class);
    }

    public function save(CodeUsage $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
