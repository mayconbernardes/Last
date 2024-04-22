<?php

namespace App\Repository;

use App\Entity\ResetPasswordRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

/**
 * @extends ServiceEntityRepository<ResetPasswordRequest>
 * Repository pour l'entité ResetPasswordRequest.
 */
class ResetPasswordRequestRepository extends ServiceEntityRepository implements ResetPasswordRequestRepositoryInterface
{
    use ResetPasswordRequestRepositoryTrait;

    /**
     * Constructeur de la classe.
     *
     * @param ManagerRegistry $registry Le registre de gestionnaire d'entités
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequest::class);
    }

    /**
     * Crée une nouvelle instance de ResetPasswordRequest.
     *
     * @param object $user L'utilisateur pour lequel la demande de réinitialisation de mot de passe est créée
     * @param \DateTimeInterface $expiresAt La date d'expiration de la demande de réinitialisation
     * @param string $selector Le sélecteur de la demande de réinitialisation
     * @param string $hashedToken Le jeton de hachage de la demande de réinitialisation
     * @return ResetPasswordRequestInterface Une instance de l'interface ResetPasswordRequestInterface
     */
    public function createResetPasswordRequest(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken): ResetPasswordRequestInterface
    {
        return new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
    }
}
