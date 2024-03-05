<?php

namespace App\Repository;

use App\Entity\TypePara;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypePara>
 *
 * @method TypePara|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePara|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePara[]    findAll()
 * @method TypePara[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeParaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePara::class);
    }

//    /**
//     * @return TypePara[] Returns an array of TypePara objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypePara
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
