<?php

namespace App\Repository;

use App\Entity\Classes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Classes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classes[]    findAll()
 * @method Classes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classes::class);
    }

    public function findByClasse($id) {

        $queryBuilder = $this->createQueryBuilder('classes');
        

        $queryBuilder->where(
            $queryBuilder->expr()->eq('classes.id', $id)
        );

        $queryBuilder->leftJoin('classes.schools', 'schools');
        $queryBuilder->addSelect('schools');

        $queryBuilder->leftJoin('schools.events', 'events');
        $queryBuilder->addSelect('events');

        $queryBuilder->leftJoin('classes.teachers', 'teachers');
        $queryBuilder->addSelect('teachers');

        $queryBuilder->leftJoin('classes.students', 'students');
        $queryBuilder->addSelect('students');

        $query = $queryBuilder->getQuery();

        return $query->getOneOrNullResult();
    }

    // /**
    //  * @return Classes[] Returns an array of Classes objects
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
    public function findOneBySomeField($value): ?Classes
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
