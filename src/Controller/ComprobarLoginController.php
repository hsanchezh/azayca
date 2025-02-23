<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Usuario;

final class ComprobarLoginController extends AbstractController
{
    #[Route('/comprobar/login', name: 'app_comprobar_login')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $usuario = new Usuario('manolo', '1234', 'manolo@correo.es');
        $entityManager->persist($usuario);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->render('comprobar_login/index.html.twig', [
            'controller_name' => 'ComprobarLoginController',
        ]);
    }
}
