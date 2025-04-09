<?php

namespace App\Repository;

use App\Entity\TarifaEspera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TarifaEspera>
 */
class TarifaEsperaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TarifaEspera::class);
    }

    //    /**
    //     * @return TarifaEspera[] Returns an array of TarifaEspera objects
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

    //    public function findOneBySomeField($value): ?TarifaEspera
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findTarifaEsperaActual(): ?TarifaEspera
    {
        return $this->findOneBy(['fin_vigencia'=>null]);
    }

    public function findAllByInicioVigencia(): ?array
    {
        return $this->findBy([], ['inicio_vigencia'=>'ASC']);
    }

    public function getJsonValues(): ?string{
        $consulta = $this->createQueryBuilder('t')
            ->select(['t.id', 't.precio_hora'])
            ->getQuery()
            ->getArrayResult();

        $resultados = [];

        foreach ($consulta as $valor){
            $resultados[$valor['id']] = $valor['precio_hora'];
        }

        return json_encode($resultados);
    }
}
