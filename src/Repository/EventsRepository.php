<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }

    public function findByEvent($id)
    {
        // de base ma requete ressemble à : SELECT * FROM 
        $queryBuilder = $this->createQueryBuilder('event');

        $queryBuilder->where(
            $queryBuilder->expr()->eq('event.id', $id)
        );
      
        $queryBuilder->leftJoin('event.schools', 'school');
        $queryBuilder->addSelect('school');

        $queryBuilder->leftJoin('school.classes', 'classes');
        $queryBuilder->addSelect('classes');

        $queryBuilder->leftJoin('classes.teachers', 'teachers');
        $queryBuilder->addSelect('teachers');

        $query = $queryBuilder->getQuery();

        return $query->getOneOrNullResult();
    }
    // /**
    //  * @return Events[] Returns an array of Events objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Events
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
