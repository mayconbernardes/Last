<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait; // Utilisation du trait pour gérer le chemin cible après l'authentification

    public const LOGIN_ROUTE = 'app_login'; // Définition de la route de connexion

    public function __construct(private UrlGeneratorInterface $urlGenerator) // Constructeur avec injection de dépendance de UrlGeneratorInterface
    {
    }

    public function authenticate(Request $request): Passport // Méthode pour l'authentification
    {
        $email = $request->getPayload()->getString('email'); // Récupération de l'email à partir des données de la requête

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email); // Stockage de l'email dans la session pour affichage dans le formulaire

        // Création du passeport d'authentification avec les informations de l'utilisateur
        return new Passport(
            new UserBadge($email), // Utilisation de l'email comme identifiant utilisateur
            new PasswordCredentials($request->getPayload()->getString('password')), // Récupération et validation du mot de passe
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')), // Validation du jeton CSRF
                new RememberMeBadge(), // Gestion de la fonctionnalité "Se souvenir de moi"
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) { // Redirection vers le chemin cible s'il existe
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_index')); // Redirection vers la page d'accueil par défaut
    }

    protected function getLoginUrl(Request $request): string // Méthode pour récupérer l'URL de connexion
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE); // Génération de l'URL de connexion à partir de la route définie
    }
}
