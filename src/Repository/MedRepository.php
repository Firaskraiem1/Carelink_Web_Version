<?php

namespace App\Repository;

use App\Entity\Med;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medecin>
 *
 * @method Medecin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medecin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medecin[]    findAll()
 * @method Medecin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Med::class);
    }
    public function paginationQuery()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->getQuery();
    }
    //    /**
    //     * @return Medecin[] Returns an array of Medecin objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Medecin
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
