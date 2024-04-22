<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

// Entité représentant une demande de réinitialisation de mot de passe
#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait; // Utilisation d'un trait pour les fonctionnalités communes des demandes de réinitialisation de mot de passe

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique de la demande de réinitialisation de mot de passe

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null; // Utilisateur associé à la demande de réinitialisation de mot de passe

    // Constructeur pour initialiser les propriétés de l'entité
    public function __construct(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    // Méthode pour récupérer l'identifiant unique de la demande de réinitialisation de mot de passe
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer l'utilisateur associé à la demande de réinitialisation de mot de passe
    public function getUser(): object
    {
        return $this->user;
    }
}
