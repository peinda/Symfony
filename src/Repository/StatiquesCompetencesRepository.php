<?php

namespace App\Repository;

use App\Entity\StatiquesCompetences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatiquesCompetences|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatiquesCompetences|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatiquesCompetences[]    findAll()
 * @method StatiquesCompetences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatiquesCompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatiquesCompetences::class);
    }

    // /**
    //  * @return StatiquesCompetences[] Returns an array of StatiquesCompetences objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatiquesCompetences
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
