<?php

namespace App\Repository;

use App\Entity\ApiDataStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApiDataStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiDataStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiDataStatus[]    findAll()
 * @method ApiDataStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiDataStatusRepository extends ServiceEntityRepository
{
    /**
     * ApiDataStatusRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiDataStatus::class);
    }

    /**
     * @param $value
     *
     * @return ApiDataStatus|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySomeField($value): ?ApiDataStatus
    {
         return $this->createQueryBuilder('a')
            ->andWhere('a.hostName = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
