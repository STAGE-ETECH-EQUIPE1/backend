<?php

namespace App\Repository\Branding;

use App\DTO\PaginationDTO;
use App\Entity\Branding\LogoVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogoVersion>
 */
class LogoVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogoVersion::class);
    }

    /**
     * @return Paginator<LogoVersion>
     */
    public function paginateByBrandingId(int $brandingId, PaginationDTO $pagination): Paginator
    {
        $qb = $this->createQueryBuilder('l')
            ->andWhere('l.branding = :brandingId')
            ->setParameter('brandingId', $brandingId)
            ->orderBy("l.{$pagination->getOrderColumn()}", $pagination->getOrderDir())
        ;

        return new Paginator(
            $qb->setFirstResult($pagination->getOffset())
                ->setMaxResults($pagination->size)
        );
    }

    //    public function findOneBySomeField($value): ?LogoVersion
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
