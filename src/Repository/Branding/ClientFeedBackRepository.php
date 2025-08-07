<?php

namespace App\Repository\Branding;

use App\Entity\Branding\ClientFeedBack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClientFeedBack>
 */
class ClientFeedBackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientFeedBack::class);
    }

    /**
     * Returns an array of ClientFeedBack objects.
     *
     * @return ClientFeedBack[]
     */
    public function findByLogoId(int $logoId): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.logoVersion = :id')
            ->setParameter('id', $logoId)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?ClientFeedBack
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
