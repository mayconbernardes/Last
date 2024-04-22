<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant un quiz
#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique du quiz

    #[ORM\Column(length: 255)]
    private ?string $title = null; // Titre du quiz

    #[ORM\Column(type: 'text')]
    private ?string $description = null; // Description du quiz

    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'quiz', orphanRemoval: true, cascade: ["persist"])]
    private Collection $questions; // Liste des questions associées au quiz

    #[ORM\OneToMany(targetEntity: Score::class, mappedBy: 'quiz')]
    private Collection $scores; // Liste des scores associés au quiz

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->scores = new ArrayCollection();
    }

    // Méthodes pour récupérer et définir les attributs

    // Renvoie l'identifiant unique du quiz
    public function getId(): ?int
    {
        return $this->id;
    }

    // Renvoie le titre du quiz
    public function getTitle(): ?string
    {
        return $this->title;
    }

    // Définit le titre du quiz
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    // Renvoie la description du quiz
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Définit la description du quiz
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    // Renvoie la collection des questions associées au quiz
    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    // Ajoute une question à la liste des questions associées au quiz
    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQuiz($this);
        }

        return $this;
    }

    // Supprime une question de la liste des questions associées au quiz
    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // Définit le côté propriétaire à null (sauf si déjà modifié)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    // Renvoie la collection des scores associés au quiz
    /**
     * @return Collection<int, Score>
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }
}
