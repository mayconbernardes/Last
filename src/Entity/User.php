<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// Entité représentant un utilisateur
#[ORM\Entity(repositoryClass: UserRepository::class)]
// Contrainte d'unicité sur l'adresse e-mail
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cette adresse e-mail.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique de l'utilisateur

    #[ORM\Column(length: 180)]
    private ?string $email = null; // Adresse e-mail de l'utilisateur

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = []; // Rôles de l'utilisateur

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null; // Mot de passe haché de l'utilisateur

    // Relation One-To-Many avec l'entité Score
    #[ORM\OneToMany(targetEntity: Score::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $scores;

    // Relation Many-To-Many avec l'entité Lesson
    #[ORM\ManyToMany(targetEntity: Lesson::class, inversedBy: 'users')]
    private Collection $user;

    // Relation Many-To-Many avec l'entité Answer
    #[ORM\ManyToMany(targetEntity: Answer::class, inversedBy: 'users')]
    private Collection $answer;
    
    public function __construct()
    {
        $this->scores = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->answer = new ArrayCollection();
    }

    // Méthode pour récupérer l'identifiant unique de l'utilisateur
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer l'adresse e-mail de l'utilisateur
    public function getEmail(): ?string
    {
        return $this->email;
    }

    // Méthode pour définir l'adresse e-mail de l'utilisateur
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    // Méthode pour récupérer l'identifiant de l'utilisateur (utilisé par l'interface UserInterface)
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    // Méthode pour récupérer les rôles de l'utilisateur (utilisé par l'interface UserInterface)
    public function getRoles(): array
    {
        $roles = $this->roles;
        // Ajouter le rôle ROLE_USER par défaut si non spécifié
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    // Méthode pour définir les rôles de l'utilisateur
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    // Méthode pour récupérer le mot de passe haché de l'utilisateur (utilisé par l'interface PasswordAuthenticatedUserInterface)
    public function getPassword(): string
    {
        return $this->password;
    }

    // Méthode pour définir le mot de passe haché de l'utilisateur
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    // Méthode pour effacer les informations sensibles de l'utilisateur (utilisé par l'interface UserInterface)
    public function eraseCredentials(): void
    {
        // Effacer des données temporaires sensibles stockées sur l'utilisateur, si nécessaire
        // Par exemple, $this->plainPassword = null;
    }

    // Méthode pour récupérer la collection de scores de l'utilisateur
    public function getScores(): Collection
    {
        return $this->scores;
    }

    // Méthode pour ajouter un score à la collection de scores de l'utilisateur
    public function addScore(Score $score): static
    {
        if (!$this->scores->contains($score)) {
            $this->scores->add($score);
            $score->setUser($this);
        }
        return $this;
    }

    // Méthode pour supprimer un score de la collection de scores de l'utilisateur
    public function removeScore(Score $score): static
    {
        if ($this->scores->removeElement($score)) {
            if ($score->getUser() === $this) {
                $score->setUser(null);
            }
        }
        return $this;
    }

    // Méthode pour récupérer la collection de leçons de l'utilisateur
    public function getUser(): Collection
    {
        return $this->user;
    }

    // Méthode pour ajouter une leçon à la collection de leçons de l'utilisateur
    public function addUser(Lesson $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }
        return $this;
    }

    // Méthode pour supprimer une leçon de la collection de leçons de l'utilisateur
    public function removeUser(Lesson $user): static
    {
        $this->user->removeElement($user);
        return $this;
    }

    // Méthode pour récupérer la collection de réponses de l'utilisateur
    public function getAnswer(): Collection
    {
        return $this->answer;
    }

    // Méthode pour ajouter une réponse à la collection de réponses de l'utilisateur
    public function addAnswer(Answer $answer): static
    {
        if (!$this->answer->contains($answer)) {
            $this->answer->add($answer);
        }
        return $this;
    }

    // Méthode pour supprimer une réponse de la collection de réponses de l'utilisateur
    public function removeAnswer(Answer $answer): static
    {
        $this->answer->removeElement($answer);
        return $this;
    }
}
