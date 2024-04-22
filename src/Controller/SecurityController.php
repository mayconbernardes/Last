<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

// Contrôleur pour gérer l'authentification et la déconnexion des utilisateurs
class SecurityController extends AbstractController
{
    // Affiche le formulaire de connexion
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Obtient l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // Déconnecte l'utilisateur
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): RedirectResponse
    {
        // Pas besoin de lever une exception ou de renvoyer autre chose,
        // Symfony gérera la redirection automatiquement.

        return $this->redirectToRoute('app_index');
    }
}
