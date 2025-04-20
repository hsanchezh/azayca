<?php

namespace App\Repository;

use App\Entity\Paciente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Paciente>
 */
class PacienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paciente::class);
    }

    //    /**
    //     * @return Paciente[] Returns an array of Paciente objects
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

    //    public function findOneBySomeField($value): ?Paciente
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getNumPacientesByLocalidad($idLocalidad){
        $resultados= $this->createQueryBuilder('p')
            ->join('p.id_localidad', 'l')
            ->select('COUNT(p)')
            ->where('l.id = :idLocalidad')
            ->groupBy('l.id')
            ->setParameter('idLocalidad', $idLocalidad)
            ->getQuery()
            ->getOneOrNullResult();

        return $resultados ? (int) array_values($resultados)[0] : 0;
    }
}
