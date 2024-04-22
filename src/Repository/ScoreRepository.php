<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    /**
     * Trouve les scores d'un utilisateur pour tous les quizzes auxquels il a participé.
     *
     * @param User $user L'utilisateur pour lequel les scores sont recherchés
     * @return Score[] Un tableau des scores pour les quizzes de l'utilisateur
     */
    public function findUserQuizScores(User $user): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.quiz', 'q') // Joindre l'entité Quiz associée au score
            ->addSelect('q') // Ajouter l'entité Quiz à la sélection
            ->join('s.user', 'u') // Joindre l'entité User associée au score
            ->addSelect('u') // Ajouter l'entité User à la sélection
            ->where('u = :user') // Condition : l'utilisateur doit être celui spécifié en paramètre
            ->setParameter('user', $user) // Définir le paramètre de l'utilisateur
            ->getQuery() // Obtenir l'objet Query
            ->getResult(); // Exécuter la requête et récupérer les résultats
    }
}
