<?php

namespace App\Repository;

use App\Entity\Students;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Students|null find($id, $lockMode = null, $lockVersion = null)
 * @method Students|null findOneBy(array $criteria, array $orderBy = null)
 * @method Students[]    findAll()
 * @method Students[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Students::class);
    }

    public function findByStudent($id)
    {
    
        $queryBuilder = $this->createQueryBuilder('students');

        $queryBuilder->where(
            $queryBuilder->expr()->eq('students.id', $id)
        );
        
        $queryBuilder->leftJoin('students.parents', 'parent');
        $queryBuilder->addSelect('parent');

          $queryBuilder->leftJoin('students.classes', 'classes');
        $queryBuilder->addSelect('classes');

        $query = $queryBuilder->getQuery();

        return $query->getOneOrNullResult();
    }
    // /**
    //  * @return Students[] Returns an array of Students objects
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
    public function findOneBySomeField($value): ?Students
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