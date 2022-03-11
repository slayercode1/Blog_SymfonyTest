<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/profil')]
class ProfilCotroller extends AbstractController
{
    #[Route('/', name: 'app_profil')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilCotrollerController',
        ]);
    }
}
