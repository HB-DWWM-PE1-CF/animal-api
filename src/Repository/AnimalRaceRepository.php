<?php

namespace App\Repository;

use App\Entity\AnimalRace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnimalRace|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalRace|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalRace[]    findAll()
 * @method AnimalRace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalRace::class);
    }

    // /**
    //  * @return AnimalRace[] Returns an array of AnimalRace objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnimalRace
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
