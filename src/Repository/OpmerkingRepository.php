<?php

namespace App\Repository;

use App\Entity\Opmerking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Opmerking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opmerking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opmerking[]    findAll()
 * @method Opmerking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpmerkingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opmerking::class);
    }

    // /**
    //  * @return Opmerking[] Returns an array of Opmerking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Opmerking
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
