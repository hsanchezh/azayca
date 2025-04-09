<?php

namespace App\Controller;

use App\Entity\TarifaEspera;
use App\Entity\TarifaKm;
use App\Entity\Viaje;
use App\Form\ViajeType;
use App\Repository\ViajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/viaje')]
final class ViajeController extends AbstractController
{
    #[Route(name: 'app_viaje_index', methods: ['GET'])]
    public function index(ViajeRepository $viajeRepository): Response
    {
        return $this->render('viaje/index.html.twig', [
            'viajes' => $viajeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_viaje_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $tarifasEsperaRepository=$entityManager->getRepository(TarifaEspera::class);
        $tarifasKmRepository=$entityManager->getRepository(TarifaKm::class);

        $valoresTarifasEspera=$tarifasEsperaRepository->getJsonValues();
        $valoresTarifasKm=$tarifasKmRepository->getJsonValues();

        $tarifaEsperaActual=$tarifasEsperaRepository->findTarifaEsperaActual();
        $tarifaKmActual=$tarifasKmRepository->findTarifaKmActual();

        $viaje = new Viaje();
        $viaje->setIdTarifaEspera($tarifaEsperaActual);
        $viaje->setIdTarifaKm($tarifaKmActual);

        $form = $this->createForm(ViajeType::class, $viaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $viaje->setImporteEspera(($viaje->getHorasEspera()?$viaje->getHorasEspera():0)*$viaje->getIdTarifaEspera()->getPrecioHora());
            $viaje->setImporteDistancia($viaje->getNumKilometros()*$viaje->getIdTarifaKm()->getPrecioKm());
            $viaje->setImporteTotal($viaje->getImporteDistancia()+$viaje->getImporteEspera());
            $viaje->setIdLocalidad($viaje->getIdPaciente()->getIdLocalidad());

            $entityManager->persist($viaje);
            $entityManager->flush();

            return $this->redirectToRoute('app_viaje_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('viaje/new.html.twig', [
            'viaje' => $viaje,
            'form' => $form,
            'valoresTarifasEspera'=>$valoresTarifasEspera,
            'valoresTarifasKm'=>$valoresTarifasKm,
        ]);
    }

    #[Route('/{id}', name: 'app_viaje_show', methods: ['GET'])]
    public function show(Viaje $viaje): Response
    {
        return $this->render('viaje/show.html.twig', [
            'viaje' => $viaje,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_viaje_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Viaje $viaje, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ViajeType::class, $viaje);
        $form->handleRequest($request);

        $tarifasEsperaRepository=$entityManager->getRepository(TarifaEspera::class);
        $tarifasKmRepository=$entityManager->getRepository(TarifaKm::class);

        $valoresTarifasEspera=$tarifasEsperaRepository->getJsonValues();
        $valoresTarifasKm=$tarifasKmRepository->getJsonValues();

        if ($form->isSubmitted() && $form->isValid()) {
            $viaje->setImporteEspera(($viaje->getHorasEspera()?$viaje->getHorasEspera():0)*$viaje->getIdTarifaEspera()->getPrecioHora());
            $viaje->setImporteDistancia($viaje->getNumKilometros()*$viaje->getIdTarifaKm()->getPrecioKm());
            $viaje->setImporteTotal($viaje->getImporteDistancia()+$viaje->getImporteEspera());
            $viaje->setIdLocalidad($viaje->getIdPaciente()->getIdLocalidad());

            $entityManager->flush();

            return $this->redirectToRoute('app_viaje_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('viaje/edit.html.twig', [
            'viaje' => $viaje,
            'form' => $form,
            'valoresTarifasEspera'=>$valoresTarifasEspera,
            'valoresTarifasKm'=>$valoresTarifasKm,
        ]);
    }

    #[Route('/{id}', name: 'app_viaje_delete', methods: ['POST'])]
    public function delete(Request $request, Viaje $viaje, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$viaje->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($viaje);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_viaje_index', [], Response::HTTP_SEE_OTHER);
    }
}
