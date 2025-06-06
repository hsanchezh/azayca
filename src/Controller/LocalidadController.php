<?php

namespace App\Controller;

use App\Entity\Localidad;
use App\Entity\Paciente;
use App\Entity\Viaje;
use App\Form\LocalidadType;
use App\Repository\LocalidadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/localidad')]
final class LocalidadController extends AbstractController
{
    #[Route(name: 'app_localidad_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $localidadRepository=$entityManager->getRepository(Localidad::class);
        $viajeRepository=$entityManager->getRepository(Viaje::class);
        $localidades = $localidadRepository->findAll();
        foreach ($localidades as $localidad) {
            $localidad->setTotalViajes($viajeRepository->getNumViajesByLocalidad($localidad->getId()));
        }

        return $this->render('localidad/index.html.twig', [
            'localidads' => $localidades,
        ]);
    }

    #[Route('/new', name: 'app_localidad_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $localidad = new Localidad();
        $form = $this->createForm(LocalidadType::class, $localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($localidad);
            $entityManager->flush();

            return $this->redirectToRoute('app_localidad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('localidad/new.html.twig', [
            'localidad' => $localidad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localidad_show', methods: ['GET'])]
    public function show(Localidad $localidad, EntityManagerInterface $entityManager): Response
    {
        $viajeRepository=$entityManager->getRepository(Viaje::class);
        $localidad->setTotalViajes($viajeRepository->getNumViajesByLocalidad($localidad->getId()));

        return $this->render('localidad/show.html.twig', [
            'localidad' => $localidad,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_localidad_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Localidad $localidad, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocalidadType::class, $localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_localidad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('localidad/edit.html.twig', [
            'localidad' => $localidad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localidad_delete', methods: ['POST'])]
    public function delete(Request $request, Localidad $localidad, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$localidad->getId(), $request->getPayload()->getString('_token'))) {

            $numViajes=$entityManager->getRepository(Viaje::class)->getNumViajesByLocalidad($localidad->getId());
            if($numViajes>0){
                $this->addFlash('error', 'La localidad '.$localidad->getNombre().' no puede ser eliminada porque tiene '.$numViajes.' viajes asociados.');
                return $this->redirectToRoute('app_main_menu', [], Response::HTTP_SEE_OTHER);
            }

            $numPacientes=$entityManager->getRepository(Paciente::class)->getNumPacientesByLocalidad($localidad->getId());
            if($numPacientes>0){
                $this->addFlash('error', 'La localidad '.$localidad->getNombre().' no puede ser eliminada porque tiene '.$numPacientes.' pacientes asociados.');
                return $this->redirectToRoute('app_main_menu', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager->remove($localidad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_localidad_index', [], Response::HTTP_SEE_OTHER);
    }
}
