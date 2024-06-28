<?php

namespace App\Repository;

use App\Entity\TwitchUserWatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TwitchUserWatch>
 */
class TwitchUserWatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwitchUserWatch::class);
    }

    //    /**
    //     * @return TwitchUserWatch[] Returns an array of TwitchUserWatch objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TwitchUserWatch
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findByUserNamesNotIn(array $excludedUserNames): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.name NOT IN (:excludedUserNames)')
            ->setParameter('excludedUserNames', $excludedUserNames)
            ->getQuery()
            ->getResult();
    }
}
