<?php

namespace App\Controller;

use App\Entity\TarifaEspera;
use App\Entity\Viaje;
use App\Form\TarifaEsperaType;
use App\Repository\TarifaEsperaRepository;
use App\Repository\ViajeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarifa/espera')]
final class TarifaEsperaController extends AbstractController
{
    #[Route(name: 'app_tarifa_espera_index', methods: ['GET'])]
    public function index(TarifaEsperaRepository $tarifaEsperaRepository): Response
    {
        return $this->render('tarifa_espera/index.html.twig', [
            'tarifa_esperas' => $tarifaEsperaRepository->findAllByInicioVigencia(),
        ]);
    }

    #[Route('/actual', name: 'app_tarifa_espera_actual', methods: ['GET'])]
    public function verActual(Request $request, TarifaEsperaRepository $tarifaEsperaRepository, EntityManagerInterface $manager): Response
    {
        $tarifaEsperaActual=$tarifaEsperaRepository->findTarifaEsperaActual();
        if($tarifaEsperaActual){
            return $this->show($tarifaEsperaActual, $manager, true);
        }

        $tarifaEspera = new TarifaEspera();
        $form = $this->createForm(TarifaEsperaType::class, $tarifaEspera);
        $form->handleRequest($request);

        return $this->render('tarifa_espera/new.html.twig', [
            'tarifa_espera' => $tarifaEspera,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_tarifa_espera_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarifaEspera = new TarifaEspera();
        $form = $this->createForm(TarifaEsperaType::class, $tarifaEspera);
        $form->handleRequest($request);

        $tarifaEsperaRepository=$entityManager->getRepository(TarifaEspera::class);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->get('id_tarifa_actual')) {
                $tarifaAnterior = $tarifaEsperaRepository->findOneBy(['id' => $request->get('id_tarifa_actual')]);
                $fechaFinalizacion=DateTime::createFromInterface($tarifaEspera->getInicioVigencia());
                $fechaFinalizacion->sub(new \DateInterval('P1D'));
                $tarifaAnterior->setFinVigencia($fechaFinalizacion);
                $entityManager->persist($tarifaAnterior);
            }

            $entityManager->persist($tarifaEspera);
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_espera_index', [], Response::HTTP_SEE_OTHER);
        }

        $tarifaActual=$tarifaEsperaRepository->findTarifaEsperaActual();

        return $this->render('tarifa_espera/new.html.twig', [
            'tarifa_espera' => $tarifaEspera,
            'form' => $form,
            'tarifa_actual'=>$tarifaActual,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifa_espera_show', methods: ['GET'])]
    public function show(TarifaEspera $tarifaEspera, EntityManagerInterface $manager, $incrustada=false): Response
    {
        $viajesRepository=$manager->getRepository(Viaje::class);

        /** @var Viaje[] $viajes */
        $viajes=$viajesRepository->findByTarifaEsperaField($tarifaEspera->getId());
        return $this->render('tarifa_espera/show.html.twig', [
            'tarifa_espera' => $tarifaEspera,
            'viajes' => $viajes,
            'incrustada' => $incrustada,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarifa_espera_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TarifaEspera $tarifaEspera, EntityManagerInterface $entityManager, $incrustada=false): Response
    {
        $form = $this->createForm(TarifaEsperaType::class, $tarifaEspera, ['include_inicio_vigencia'=>false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_espera_index', [], Response::HTTP_SEE_OTHER);
        }

        $viajesRepository=$entityManager->getRepository(Viaje::class);

        /** @var Viaje[] $viajes */
        $viajes=$viajesRepository->findByTarifaEsperaField($tarifaEspera->getId());

        return $this->render('tarifa_espera/edit.html.twig', [
            'tarifa_espera' => $tarifaEspera,
            'form' => $form,
            'viajes' => $viajes,
            'incrustada' => $incrustada,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifa_espera_delete', methods: ['POST'])]
    public function delete(Request $request, TarifaEspera $tarifaEspera, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarifaEspera->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tarifaEspera);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tarifa_espera_index', [], Response::HTTP_SEE_OTHER);
    }
}
