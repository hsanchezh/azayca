<?php

namespace App\Controller;

use App\Entity\TarifaKm;
use App\Form\TarifaKmType;
use App\Repository\TarifaKmRepository;
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
            'tarifa_kms' => $tarifaKmRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tarifa_km_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarifaKm = new TarifaKm();
        $form = $this->createForm(TarifaKmType::class, $tarifaKm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tarifaKm);
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_km_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarifa_km/new.html.twig', [
            'tarifa_km' => $tarifaKm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifa_km_show', methods: ['GET'])]
    public function show(TarifaKm $tarifaKm): Response
    {
        return $this->render('tarifa_km/show.html.twig', [
            'tarifa_km' => $tarifaKm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarifa_km_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TarifaKm $tarifaKm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TarifaKmType::class, $tarifaKm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_km_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarifa_km/edit.html.twig', [
            'tarifa_km' => $tarifaKm,
            'form' => $form,
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
