<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant une réponse à une question
#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique de la réponse

    #[ORM\Column(length: 255)]
    private ?string $text = null; // Texte de la réponse

    #[ORM\Column]
    private ?bool $isCorrect = null; // Indique si la réponse est correcte ou non

    #[ORM\ManyToOne(inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null; // Question associée à la réponse

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'answer')]
    private Collection $users; // Utilisateurs qui ont sélectionné cette réponse

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    // Méthodes pour récupérer et définir les attributs

    // Renvoie l'identifiant unique de la réponse
    public function getId(): ?int
    {
        return $this->id;
    }

    // Renvoie le texte de la réponse
    public function getText(): ?string
    {
        return $this->text;
    }

    // Définit le texte de la réponse
    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    // Renvoie si la réponse est correcte ou non
    public function isIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    // Définit si la réponse est correcte ou non
    public function setIsCorrect(bool $isCorrect): static
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    // Renvoie la question associée à la réponse
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    // Définit la question associée à la réponse
    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Renvoie la collection des utilisateurs ayant sélectionné cette réponse.
     *
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    // Ajoute un utilisateur à la liste des utilisateurs ayant sélectionné cette réponse
    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAnswer($this);
        }

        return $this;
    }

    // Supprime un utilisateur de la liste des utilisateurs ayant sélectionné cette réponse
    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeAnswer($this);
        }

        return $this;
    }
}
