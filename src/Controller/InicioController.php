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
        $numConductores = $entityManager->getRepository(Conductor::class)->count();

        $numUsuarios = $entityManager->getRepository(Usuario::class)->count();

        $numLocalidad = $entityManager->getRepository(Localidad::class)->count();

        $numPaciente = $entityManager->getRepository(Paciente::class)->count();

        $numTarifaEspera = $entityManager->getRepository(TarifaEspera::class)->count();

        $numTarifaKm = $entityManager->getRepository(TarifaKm::class)->count();

        $numViajes = $entityManager->getRepository(Viaje::class)->count();

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

    #[Route(path: '/reiniciar', name: 'app_reiniciar')]
    public function reiniciar(EntityManagerInterface $entityManager): Response
    {
        $entityManager->createQueryBuilder()
            ->from(Viaje::class, 'u')
            ->delete()
            ->getQuery()
            ->execute();

        $entityManager->createQueryBuilder()
            ->from(Usuario::class, 'u')
            ->delete()
            ->getQuery()
            ->execute();

        $entityManager->createQueryBuilder()
            ->from(TarifaKm::class, 'u')
            ->delete()
            ->getQuery()
            ->execute();

        $entityManager->createQueryBuilder()
            ->from(TarifaEspera::class, 'u')
            ->delete()
            ->getQuery()
            ->execute();

        $entityManager->createQueryBuilder()
            ->from(Paciente::class, 'u')
            ->delete()
            ->getQuery()
            ->execute();

        $entityManager->createQueryBuilder()
            ->from(Localidad::class, 'u')
            ->delete()
            ->getQuery()
            ->execute();

        $entityManager->createQueryBuilder()
            ->from(Conductor::class, 'u')
            ->delete()
            ->getQuery()
            ->execute();

        $entityManager->flush();

        return $this->index($entityManager);
    }
}
