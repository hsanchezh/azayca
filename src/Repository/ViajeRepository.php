<?php

namespace App\Repository;

use App\Entity\Viaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Viaje>
 */
class ViajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Viaje::class);
    }

//    /**
//     * @return Viaje[] Returns an array of Viaje objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Viaje
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByTarifaEsperaField($value): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.id_tarifa_espera = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByTarifaKmField($value): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.id_tarifa_km = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
