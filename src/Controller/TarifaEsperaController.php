<?php

namespace App\Controller;

use App\Entity\TarifaEspera;
use App\Form\TarifaEsperaType;
use App\Repository\TarifaEsperaRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            'tarifa_esperas' => $tarifaEsperaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tarifa_espera_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tarifaEspera = new TarifaEspera();
        $form = $this->createForm(TarifaEsperaType::class, $tarifaEspera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tarifaEspera);
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_espera_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarifa_espera/new.html.twig', [
            'tarifa_espera' => $tarifaEspera,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifa_espera_show', methods: ['GET'])]
    public function show(TarifaEspera $tarifaEspera): Response
    {
        return $this->render('tarifa_espera/show.html.twig', [
            'tarifa_espera' => $tarifaEspera,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarifa_espera_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TarifaEspera $tarifaEspera, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TarifaEsperaType::class, $tarifaEspera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tarifa_espera_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tarifa_espera/edit.html.twig', [
            'tarifa_espera' => $tarifaEspera,
            'form' => $form,
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
