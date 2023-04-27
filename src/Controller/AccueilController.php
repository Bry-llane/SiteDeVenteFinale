<?php

namespace App\Controller;

use App\Service\PasswordChecker;
use App\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function indexAction(SecurityController $security, PasswordChecker $passwordChecker): Response
    {
        $user = $this->getUser();
        if ($user) {
            $password = $user->getPassword();
            if ($passwordChecker->isStrongPassword($password)) {
                $args = ['password' => 'Le mot de passe est sûr.',
                    'role' => $user->getRoles()];
            } else {
                $args = ['password' => 'Le mot de passe n\'est pas sûr.',
                    'role' => $user->getRoles()];
            }
        } else {
            $args = ['password' => 'Vous n\'êtes pas connecté.',
                'role' => ['ANONYME']
            ];
        }



        return $this->render('accueil.html.twig', $args);
    }
}
