<?php

namespace App\Repository;

use App\Entity\TarifaKm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TarifaKm>
 */
class TarifaKmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TarifaKm::class);
    }

    //    /**
    //     * @return TarifaKm[] Returns an array of TarifaKm objects
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

    //    public function findOneBySomeField($value): ?TarifaKm
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findTarifaKmActual(): ?TarifaKm
    {
        return $this->findOneBy(['fin_vigencia'=>null]);
    }

    public function findAllByInicioVigencia(): ?array
    {
        return $this->findBy([], ['inicio_vigencia'=>'ASC']);
    }

    public function getJsonValues(): ?string{
        $consulta = $this->createQueryBuilder('t')
            ->select(['t.id', 't.precio_km'])
            ->getQuery()
            ->getArrayResult();

        if(empty($consulta)){
            return null;
        }

        $resultados = [];

        foreach ($consulta as $valor){
            $resultados[$valor['id']] = $valor['precio_km'];
        }

        return json_encode($resultados);
    }
}
