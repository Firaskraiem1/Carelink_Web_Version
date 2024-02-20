<?php

namespace App\Repository;

use App\Entity\CategoryEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryEvenement>
 *
 * @method CategoryEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryEvenement[]    findAll()
 * @method CategoryEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEvenement::class);
    }

//    /**
//     * @return CategoryEvenement[] Returns an array of CategoryEvenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategoryEvenement
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
