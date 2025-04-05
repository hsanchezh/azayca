<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class MainMenuController extends AbstractController
{
    #[Route('/main/menu', name: 'app_main_menu')]
    public function index(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        return $this->render('main_menu/index.html.twig', [
            'controller_name' => 'MainMenuController'
        ]);
    }
}
