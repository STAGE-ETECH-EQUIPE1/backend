<?php

namespace App\Repository\Payment;

use App\Entity\Payment\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Payment>
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    /**
     * Find Payment By Reference number and Transaction ID.
     */
    public function findOneByTransactionIdAndReference(string $reference, string $transactionId): ?Payment
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.transactionId = :transactionId')
            ->andWhere('p.referenceNumber = :referenceNumber')
            ->setParameter('transactionId', $transactionId)
            ->setParameter('referenceNumber', $reference)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //    /**
    //     * @return Payment[] Returns an array of Payment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
}
