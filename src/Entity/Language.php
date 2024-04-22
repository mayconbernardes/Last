<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant une langue
#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // Identifiant unique de la langue

    #[ORM\Column(length: 255)]
    private ?string $name = null; // Nom de la langue

    #[ORM\OneToMany(targetEntity: Lesson::class, mappedBy: 'language')]
    private Collection $lessons; // Leçons associées à la langue

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
    }

    // Méthodes pour récupérer et définir les attributs

    // Renvoie l'identifiant unique de la langue
    public function getId(): ?int
    {
        return $this->id;
    }

    // Renvoie le nom de la langue
    public function getName(): ?string
    {
        return $this->name;
    }

    // Définit le nom de la langue
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Renvoie la collection des leçons associées à la langue.
     *
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    // Ajoute une leçon à la liste des leçons associées à la langue
    public function addLesson(Lesson $lesson): static
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
            $lesson->setLanguage($this);
        }

        return $this;
    }

    // Supprime une leçon de la liste des leçons associées à la langue
    public function removeLesson(Lesson $lesson): static
    {
        if ($this->lessons->removeElement($lesson)) {
            // Définit le côté propriétaire sur null (sauf si déjà modifié)
            if ($lesson->getLanguage() === $this) {
                $lesson->setLanguage(null);
            }
        }

        return $this;
    }
}
