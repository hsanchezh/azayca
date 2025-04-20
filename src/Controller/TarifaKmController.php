<?php

namespace App\Controller;

use App\Entity\TarifaKm;
use App\Entity\Viaje;
use App\Form\TarifaKmType;
use App\Repository\TarifaKmRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarifa/km')]
final class TarifaKmController extends AbstractController
{
    #[Route(name: 'app_tarifa_km_index', methods: ['GET'])]
    public function index(TarifaKmRepository $tarifaKmRepository): Response
    {
        return $this->render('tarifa_km/index.html.twig', [
            'tarifa_kms' => $tarifaKmRepository->findAllByInicioVigencia(),
        ]);
    }

    #[Route('/actual', name: 'app_tarifa_km_actual', methods: ['GET'])]
    public function verActual(Request $request, TarifaKmRepository $tarifaKmRepository, EntityManagerInterface $manager): Response
    {
        $tarifaKmActual=$tarifaKmRepository->findTarifaKmActual();
        if($tarifaKmActual){
            return $this->show($tarifaKmActual, $manager, true);
        }

        return $this->redirectToRoute('app_tarifa_km_new');
    }

    #[Route('/new', name: 'app_tarifa_km_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarifaKm = new TarifaKm();
        $form = $this->createForm(TarifaKmType::class, $tarifaKm);
        $form->handleRequest($request);

        $tarifaKmRepository=$entityManager->getRepository(TarifaKm::class);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->get('id_tarifa_actual')) {
                $tarifaAnterior = $tarifaKmRepository->findOneBy(['id' => $request->get('id_tarifa_actual')]);
                $fechaFinalizacion=DateTime::createFromInterface($tarifaKm->getInicioVigencia());
                $fechaFinalizacion->sub(new \DateInterval('P1D'));
                $tarifaAnterior->setFinVigencia($fechaFinalizacion);
                $entityManager->persist($tarifaAnterior);
            }

            $entityManager->persist($tarifaKm);
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_km_index', [], Response::HTTP_SEE_OTHER);
        }

        $tarifaActual=$tarifaKmRepository->findTarifaKmActual();

        return $this->render('tarifa_km/new.html.twig', [
            'tarifa_km' => $tarifaKm,
            'form' => $form,
            'tarifa_actual'=>$tarifaActual,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifa_km_show', methods: ['GET'])]
    public function show(TarifaKm $tarifaKm, EntityManagerInterface $manager, $incrustada=false): Response
    {
        $viajesRepository=$manager->getRepository(Viaje::class);

        /** @var Viaje[] $viajes */
        $viajes=$viajesRepository->findByTarifaKmField($tarifaKm->getId());

        return $this->render('tarifa_km/show.html.twig', [
            'tarifa_km' => $tarifaKm,
            'viajes' => $viajes,
            'incrustada' => $incrustada,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarifa_km_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TarifaKm $tarifaKm, EntityManagerInterface $entityManager, $incrustada=false): Response
    {
        $form = $this->createForm(TarifaKmType::class, $tarifaKm, ['include_inicio_vigencia'=>false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_km_index', [], Response::HTTP_SEE_OTHER);
        }

        $viajesRepository=$entityManager->getRepository(Viaje::class);

        /** @var Viaje[] $viajes */
        $viajes=$viajesRepository->findByTarifaKmField($tarifaKm->getId());

        return $this->render('tarifa_km/edit.html.twig', [
            'tarifa_km' => $tarifaKm,
            'form' => $form,
            'viajes' => $viajes,
            'incrustada' => $incrustada,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifa_km_delete', methods: ['POST'])]
    public function delete(Request $request, TarifaKm $tarifaKm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarifaKm->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tarifaKm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tarifa_km_index', [], Response::HTTP_SEE_OTHER);
    }
}
