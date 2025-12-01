<?php

namespace App\Repository;

use App\Entity\Medecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medecin::class);
    }

    public function findAllActive(): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.active = :active')
            ->setParameter('active', 1)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Other methods can remain the same or be modified as needed
}
