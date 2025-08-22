<?php

namespace App\Repository\Branding;

use App\DTO\PaginationDTO;
use App\Entity\Auth\Client;
use App\Entity\Branding\BrandingProject;
use App\Utils\Paginator\PaginatorUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BrandingProject>
 */
class BrandingProjectRepository extends ServiceEntityRepository
{
    private const array ORDER_COLUMNS = [
        'id', 'description', 'createdAt', 'updatedAt', 'deadLine',
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrandingProject::class);
    }

    /**
     * @return Paginator<BrandingProject>
     */
    public function paginateByClient(Client $client, PaginationDTO $pagination): Paginator
    {
        $orderColumn = PaginatorUtils::getArrayValue(self::ORDER_COLUMNS, $pagination->getOrderColumn());

        $qb = $this->createQueryBuilder('b')
            ->andWhere('b.client = :client')
            ->setParameter('client', $client)
            ->orderBy("b.{$orderColumn}", $pagination->getOrderDir())
        ;

        return new Paginator(
            $qb->setFirstResult($pagination->getOffset())
                ->setMaxResults($pagination->size)
        );
    }

    //    public function findOneBySomeField($value): ?BrandingProject
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
