<?php

namespace App\Repository;

use App\Entity\Schools;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Schools|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schools|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schools[]    findAll()
 * @method Schools[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schools::class);
    }


    public function findWithSchool($id)
    {
        // de base ma requete ressemble à : SELECT * FROM 
        $queryBuilder = $this->createQueryBuilder('schools');

        // je personnalise ma requete

        // je precise que je souhaite recupérer un element grace a son ID
        $queryBuilder->where(
            $queryBuilder->expr()->eq('schools.id', $id)
        );
        // maintenant le query builder va me donner une requete du genre :
        // SELECT * FROM tvShow WHERE tvShow.id = 6

        $queryBuilder->leftJoin('schools.events', 'events');
        $queryBuilder->addSelect('events');

        // je recupére les categories liés a ma serie
        $queryBuilder->leftJoin('schools.classes', 'classes');
        // j'ajoute aux objets à créer les catégorie
        $queryBuilder->addSelect('classes');

        $queryBuilder->leftJoin('classes.teachers', 'teachers');
        $queryBuilder->addSelect('teachers');

        $queryBuilder->leftJoin('classes.students', 'students');
        $queryBuilder->addSelect('students');

        $queryBuilder->leftJoin('students.parents', 'parents');
        $queryBuilder->addSelect('parents');

        $query = $queryBuilder->getQuery();

        return $query->getOneOrNullResult();
    }

    // /**
    //  * @return Schools[] Returns an array of Schools objects
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
    public function findOneBySomeField($value): ?Schools
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