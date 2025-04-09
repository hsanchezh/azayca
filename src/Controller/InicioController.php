<?php

namespace App\Controller;

use App\Entity\Conductor;
use App\Entity\Localidad;
use App\Entity\Paciente;
use App\Entity\TarifaEspera;
use App\Entity\TarifaKm;
use App\Entity\Usuario;
use App\Entity\Viaje;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InicioController extends AbstractController
{
    #[Route('/inicio', name: 'app_inicio')]
    #[Route(path: '/', name: 'app_root')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $numConductores = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(Conductor::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        $numUsuarios = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(Usuario::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        $numLocalidad = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(Localidad::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        $numPaciente = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(Paciente::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        $numTarifaEspera = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(TarifaEspera::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        $numTarifaKm = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(TarifaKm::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        $numViajes = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(Viaje::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('inicio/index.html.twig', [
            'controller_name' => 'InicioController',
            'numConductores' => $numConductores,
            'numUsuarios' => $numUsuarios,
            'numLocalidad' => $numLocalidad,
            'numPaciente' => $numPaciente,
            'numTarifaEspera' => $numTarifaEspera,
            'numTarifaKm' => $numTarifaKm,
            'numViajes' => $numViajes,
        ]);
    }
}
