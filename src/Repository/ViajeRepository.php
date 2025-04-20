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

    public function getNumViajesByLocalidad($idLocalidad){
        $resultados= $this->createQueryBuilder('v')
            ->join('v.id_localidad', 'l')
            ->select('COUNT(v)')
            ->where('l.id = :idLocalidad')
            ->groupBy('l.id')
            ->setParameter('idLocalidad', $idLocalidad)
            ->getQuery()
            ->getOneOrNullResult();

        return $resultados ? (int) array_values($resultados)[0] : 0;
    }

    public function getNumViajesByConductor($idConductor){
        $resultados= $this->createQueryBuilder('v')
            ->join('v.id_conductor', 'c')
            ->select('COUNT(v)')
            ->where('c.id = :idConductor')
            ->groupBy('c.id')
            ->setParameter('idConductor', $idConductor)
            ->getQuery()
            ->getOneOrNullResult();

        return $resultados ? (int) array_values($resultados)[0] : 0;
    }

    public function getNumViajesByPaciente($idPaciente){
        $resultados= $this->createQueryBuilder('v')
            ->join('v.id_paciente', 'p')
            ->select('COUNT(v)')
            ->where('p.id = :idPaciente')
            ->groupBy('p.id')
            ->setParameter('idPaciente', $idPaciente)
            ->getQuery()
            ->getOneOrNullResult();

        return $resultados ? (int) array_values($resultados)[0] : 0;
    }


}
