<?php

namespace App\Repository;

use App\Entity\Apod;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Apod>
 *
 * @method Apod|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apod|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apod[]    findAll()
 * @method Apod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apod::class);
    }

    public function add(Apod $apod, bool $flush = false): void
    {
        $this->getEntityManager()->persist($apod);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}