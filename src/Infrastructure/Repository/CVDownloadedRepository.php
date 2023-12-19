<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\CVDownloaded;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CVDownloaded>
 *
 * @method CVDownloaded|null find($id, $lockMode = null, $lockVersion = null)
 * @method CVDownloaded|null findOneBy(array $criteria, array $orderBy = null)
 * @method CVDownloaded[]    findAll()
 * @method CVDownloaded[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CVDownloadedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CVDownloaded::class);
    }

    public function save(CVDownloaded $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
