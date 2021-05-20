<?php

namespace App\Repository;

use App\Entity\Taakverdeling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Taakverdeling|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taakverdeling|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taakverdeling[]    findAll()
 * @method Taakverdeling[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaakverdelingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Taakverdeling::class);
    }

    // /**
    //  * @return Taakverdeling[] Returns an array of Taakverdeling objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Taakverdeling
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
