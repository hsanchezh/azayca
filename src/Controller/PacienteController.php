<?php

namespace App\Controller;

use App\Entity\Localidad;
use App\Entity\Paciente;
use App\Entity\Viaje;
use App\Form\LocalidadType;
use App\Form\PacienteType;
use App\Repository\LocalidadRepository;
use App\Repository\PacienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/paciente')]
final class PacienteController extends AbstractController
{
    #[Route(name: 'app_paciente_index', methods: ['GET'])]
    public function index(PacienteRepository $pacienteRepository): Response
    {
        return $this->render('paciente/index.html.twig', [
            'pacientes' => $pacienteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_paciente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$entityManager->getRepository(Localidad::class)->count()){
            $this->addFlash('error', 'Antes de crear un paciente es necesario que exista, como mínimo, una localidad.');
            return $this->redirectToRoute('app_localidad_new');
        }

        $paciente = new Paciente();
        $form = $this->createForm(PacienteType::class, $paciente, ['include_codigo'=>false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paciente->generarCodigo();
            $entityManager->persist($paciente);
            $entityManager->flush();

            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paciente/new.html.twig', [
            'paciente' => $paciente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paciente_show', methods: ['GET'])]
    public function show(Paciente $paciente): Response
    {
        return $this->render('paciente/show.html.twig', [
            'paciente' => $paciente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_paciente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paciente $paciente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PacienteType::class, $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paciente/edit.html.twig', [
            'paciente' => $paciente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paciente_delete', methods: ['POST'])]
    public function delete(Request $request, Paciente $paciente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paciente->getId(), $request->getPayload()->getString('_token'))) {
            $numViajes=$entityManager->getRepository(Viaje::class)->getNumViajesByPaciente($paciente->getId());
            if($numViajes>0){
                $this->addFlash('error', 'El paciente '.$paciente->getNombreCompleto().' no puede ser eliminado porque tiene '.$numViajes.' viajes asociados.');
                return $this->redirectToRoute('app_main_menu', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager->remove($paciente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
    }
}
