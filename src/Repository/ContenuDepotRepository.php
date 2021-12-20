<?php

namespace App\Repository;

use App\Entity\ContenuDepot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContenuDepot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContenuDepot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContenuDepot[]    findAll()
 * @method ContenuDepot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContenuDepotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContenuDepot::class);
    }

    // /**
    //  * @return ContenuDepot[] Returns an array of ContenuDepot objects
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
    public function findOneBySomeField($value): ?ContenuDepot
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
