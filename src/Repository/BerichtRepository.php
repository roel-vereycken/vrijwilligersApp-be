<?php

namespace App\Repository;

use App\Entity\Bericht;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bericht|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bericht|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bericht[]    findAll()
 * @method Bericht[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BerichtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bericht::class);
    }

    // /**
    //  * @return Bericht[] Returns an array of Bericht objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bericht
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
