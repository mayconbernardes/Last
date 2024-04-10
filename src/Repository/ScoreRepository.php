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

    public function findUserQuizScores(User $user): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.quiz', 'q')
            ->addSelect('q')
            ->join('s.user', 'u')
            ->addSelect('u')
            ->where('u = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
