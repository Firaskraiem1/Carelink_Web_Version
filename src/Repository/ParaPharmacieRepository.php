<?php

namespace App\Repository;

use App\Entity\ParaPharmacie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParaPharmacie>
 *
 * @method ParaPharmacie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParaPharmacie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParaPharmacie[]    findAll()
 * @method ParaPharmacie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParaPharmacieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParaPharmacie::class);
    }

    public function isUnique(ParaPharmacie $paraPharmacie): bool
    {
        $existingRecord = $this->findOneBy([
            'idPara' => $paraPharmacie->getId(),
            'email' => $paraPharmacie->getEmail(),
            'numtel' => $paraPharmacie->getNumtel(),
            'nomPara' => $paraPharmacie->getNomPara(),
        ]);

        return $existingRecord === null;
    }
    public function findBySearch($search) 
    {
      $qb = $this->createQueryBuilder('p');
    
      $attributes = [
        'p.nomPara', 
        'p.email',
        'p.nbrPharmaciens',
        'p.numtel',
        'p.etatPara',
        'p.ville.ville' 
      ];
    
      foreach($attributes as $attribute) {
        $qb->orWhere($attribute . ' LIKE :search');
      }
    
      $qb->setParameter('search', "%$search%");
    
      return $qb->getQuery()->getResult();
    }
public function findByOrder($field, $direction) 
{
  return $this->createQueryBuilder('p')
   ->orderBy($field, $direction)
   ->getQuery()
   ->getResult();
}

//    /**
//     * @return ParaPharmacie[] Returns an array of ParaPharmacie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParaPharmacie
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
