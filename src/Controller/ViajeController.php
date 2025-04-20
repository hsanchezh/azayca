<?php

namespace App\Controller;

use App\Entity\Conductor;
use App\Entity\Localidad;
use App\Entity\Paciente;
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

        if(!$valoresTarifasEspera) {
            $this->addFlash('error', 'Antes de crear un viaje es necesario que exista una tarifa de espera.');
            return $this->redirectToRoute('app_tarifa_espera_new');
        } elseif (!$valoresTarifasKm) {
            $this->addFlash('error', 'Antes de crear un viaje es necesario que exista una tarifa por kilómetros.');
            return $this->redirectToRoute('app_tarifa_km_new');
        } elseif(!$entityManager->getRepository(Localidad::class)->count()){
            $this->addFlash('error', 'Antes de crear un paciente es necesario que exista, como mínimo, una localidad.');
            return $this->redirectToRoute('app_localidad_new');
        } elseif(!$entityManager->getRepository(Paciente::class)->count()){
            $this->addFlash('error', 'Antes de crear un viaje es necesario que exista, como mínimo, un paciente.');
            return $this->redirectToRoute('app_paciente_new');
        } elseif(!$entityManager->getRepository(Conductor::class)->count()){
            $this->addFlash('error', 'Antes de crear un viaje es necesario que exista, como mínimo, un conductor.');
            return $this->redirectToRoute('app_conductor_new');
        }

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
