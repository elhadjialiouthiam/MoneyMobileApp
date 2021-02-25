<?php

namespace App\Repository;

use App\Entity\Caisier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Caisier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caisier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caisier[]    findAll()
 * @method Caisier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaisierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caisier::class);
    }

    // /**
    //  * @return Caisier[] Returns an array of Caisier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Caisier
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
