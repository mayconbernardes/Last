<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 * Repository pour l'entité User.
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * Constructeur de la classe.
     *
     * @param ManagerRegistry $registry Le registre de gestionnaire d'entités
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Utilisé pour mettre à niveau (re-hasher) automatiquement le mot de passe de l'utilisateur au fil du temps.
     *
     * @param PasswordAuthenticatedUserInterface $user L'utilisateur dont le mot de passe doit être mis à jour
     * @param string $newHashedPassword Le nouveau mot de passe hashé
     * @throws UnsupportedUserException Si l'objet utilisateur n'est pas pris en charge
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        // Met à jour le mot de passe de l'utilisateur avec le nouveau mot de passe hashé
        $user->setPassword($newHashedPassword);

        // Persiste les modifications de l'utilisateur dans la base de données
        $this->getEntityManager()->persist($user);
        
        // Effectue les modifications dans la base de données
        $this->getEntityManager()->flush();
    }

    // Méthode générée automatiquement par Symfony, elle est commentée pour l'instant.

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
}
