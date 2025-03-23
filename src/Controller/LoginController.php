<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        // Récupération d'une erreur de login et sockage
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier Username renter par l'utilisateur (email)
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = $security->getUser();

        if($user) {
            return new RedirectResponse($this->generateUrl('accueil'));
        }

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupération d'une erreur de login et sockage
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier Username renter par l'utilisateur (email)
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }
}
