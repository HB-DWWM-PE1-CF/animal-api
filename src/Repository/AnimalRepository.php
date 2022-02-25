<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function countAll()
    {
        // SELECT COUNT(*) AS total FROM animals AS a
        $qb = $this->_em->createQueryBuilder()
            ->select('COUNT(a) AS total')
            ->from($this->getEntityName(), 'a')
        ;

        $res = $qb->getQuery()->getOneOrNullResult();
        return $res['total'];
    }

    public function countAllWithoutOwner($startAt = null)
    {
        // SELECT COUNT(*) AS total FROM animals AS a WHERE a.owner IS NULL
        $qb = $this->_em->createQueryBuilder()
            ->select('COUNT(a) AS total')
            ->from($this->getEntityName(), 'a')
            ->where('a.owner IS NULL')
        ;

        $res = $qb->getQuery()->getOneOrNullResult();
        return $res['total'];
    }
}
