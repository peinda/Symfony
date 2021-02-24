<?php

namespace App\Repository;

use App\Entity\FileDiscussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FileDiscussion|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileDiscussion|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileDiscussion[]    findAll()
 * @method FileDiscussion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileDiscussionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileDiscussion::class);
    }

    // /**
    //  * @return FileDiscussion[] Returns an array of FileDiscussion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileDiscussion
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
