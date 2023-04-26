<?php

namespace App\Controller;

use App\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function indexAction(SecurityController $security): Response
    {
        $user = $this->getUser();
        return $this->render('accueil.html.twig');
    }
}
