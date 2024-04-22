<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant le score d'un utilisateur pour un quiz
#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique du score

    #[ORM\Column]
    private ?int $score = null; // Score obtenu par l'utilisateur pour le quiz

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCompleted = null; // Date de complétion du quiz

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null; // Utilisateur associé au score

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null; // Quiz associé au score

    // Méthode pour récupérer l'identifiant unique du score
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer le score
    public function getScore(): ?int
    {
        return $this->score;
    }

    // Méthode pour définir le score
    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }

    // Méthode pour récupérer la date de complétion du quiz
    public function getDateCompleted(): ?\DateTimeInterface
    {
        return $this->dateCompleted;
    }

    // Méthode pour définir la date de complétion du quiz
    public function setDateCompleted(\DateTimeInterface $dateCompleted): self
    {
        $this->dateCompleted = $dateCompleted;
        return $this;
    }

    // Méthode pour récupérer l'utilisateur associé au score
    public function getUser(): ?User
    {
        return $this->user;
    }

    // Méthode pour définir l'utilisateur associé au score
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    // Méthode pour récupérer le quiz associé au score
    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    // Méthode pour définir le quiz associé au score
    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;
        return $this;
    }
}
