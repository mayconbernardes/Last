<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant une question d'un quiz
#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique de la question

    #[ORM\Column(length: 255)]
    private ?string $text = null; // Texte de la question

    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: "question", orphanRemoval: true, cascade: ["persist"])]
    private Collection $answers; // Réponses associées à la question

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null; // Quiz auquel appartient la question

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    // Méthodes pour récupérer et définir les attributs

    // Renvoie l'identifiant unique de la question
    public function getId(): ?int
    {
        return $this->id;
    }

    // Renvoie le texte de la question
    public function getText(): ?string
    {
        return $this->text;
    }

    // Définit le texte de la question
    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    // Renvoie la collection des réponses associées à la question
    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    // Ajoute une réponse à la liste des réponses associées à la question
    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    // Supprime une réponse de la liste des réponses associées à la question
    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            // Définit le côté propriétaire à null (sauf si déjà modifié)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    // Renvoie le quiz auquel appartient la question
    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    // Définit le quiz auquel appartient la question
    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }
}
