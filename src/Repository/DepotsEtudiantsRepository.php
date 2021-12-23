<?php

namespace App\Repository;

use App\Entity\DepotsEtudiants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepotsEtudiants|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepotsEtudiants|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepotsEtudiants[]    findAll()
 * @method DepotsEtudiants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepotsEtudiantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepotsEtudiants::class);
    }

    // /**
    //  * @return DepotsEtudiants[] Returns an array of DepotsEtudiants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DepotsEtudiants
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
