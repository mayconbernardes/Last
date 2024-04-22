<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant une leçon
#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique de la leçon

    #[ORM\Column(length: 255)]
    private ?string $title = null; // Titre de la leçon

    #[ORM\Column(type: Types::TEXT)]
    private ?string $transcription = null; // Transcription de la leçon

    #[ORM\Column(length: 255)]
    private ?string $src = null; // Source de la leçon

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $language = null; // Langue de la leçon

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'user')]
    private Collection $users; // Utilisateurs associés à la leçon

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    // Méthodes pour récupérer et définir les attributs

    // Renvoie l'identifiant unique de la leçon
    public function getId(): ?int
    {
        return $this->id;
    }

    // Renvoie le titre de la leçon
    public function getTitle(): ?string
    {
        return $this->title;
    }

    // Définit le titre de la leçon
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    // Renvoie la transcription de la leçon
    public function getTranscription(): ?string
    {
        return $this->transcription;
    }

    // Définit la transcription de la leçon
    public function setTranscription(string $transcription): static
    {
        $this->transcription = $transcription;

        return $this;
    }

    // Renvoie la source de la leçon
    public function getSrc(): ?string
    {
        return $this->src;
    }

    // Définit la source de la leçon
    public function setSrc(string $src): static
    {
        $this->src = $src;

        return $this;
    }

    // Renvoie la langue de la leçon
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    // Définit la langue de la leçon
    public function setLanguage(?Language $language): static
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Renvoie la collection des utilisateurs associés à la leçon.
     *
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    // Ajoute un utilisateur à la liste des utilisateurs associés à la leçon
    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addUser($this);
        }

        return $this;
    }

    // Supprime un utilisateur de la liste des utilisateurs associés à la leçon
    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeUser($this);
        }

        return $this;
    }
}
