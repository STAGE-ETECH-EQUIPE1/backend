<?php

namespace App\Repository\Branding;

use App\DTO\PaginationDTO;
use App\Entity\Branding\ClientFeedBack;
use App\Utils\Paginator\PaginatorUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClientFeedBack>
 */
class ClientFeedBackRepository extends ServiceEntityRepository
{
    private const array ORDER_COLUMNS = [
        'id', 'comment', 'createdAt', 'client',
    ];

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

    /**
     * Paginate Logo feedbacks.
     *
     * @return Paginator<ClientFeedBack>
     */
    public function paginateByLogoId(int $logoId, PaginationDTO $pagination): Paginator
    {
        $orderColumn = PaginatorUtils::getArrayValue(self::ORDER_COLUMNS, $pagination->getOrderColumn());

        $qb = $this->createQueryBuilder('f')
            ->andWhere('f.logoVersion = :id')
            ->setParameter('id', $logoId)
            ->orderBy("f.{$orderColumn}", $pagination->getOrderDir())
        ;

        return new Paginator(
            $qb->setFirstResult($pagination->getOffset())
                ->setMaxResults($pagination->size)
        );
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
