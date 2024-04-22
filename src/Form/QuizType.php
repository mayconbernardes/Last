<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Score;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajoute les champs pour le titre et la description du quiz
        $builder
            ->add('title') // Champ pour le titre du quiz
            ->add('description') // Champ pour la description du quiz
            // Ajoute une collection de champs de question pour les questions du quiz
            ->add('questions', CollectionType::class, [
                'entry_type' => QuestionType::class, // Type de chaque élément de la collection
                'allow_add' => true, // Autorise l'ajout de nouvelles questions
                'allow_delete' => true, // Autorise la suppression des questions existantes
                'by_reference' => false, // Passe chaque question en tant que référence d'objet
                'entry_options' => ['label' => false], // Masque les étiquettes pour chaque champ de question
                'attr' => [
                    'data-controller' => 'form-collection', // Définit un contrôleur de formulaire pour gérer les collections
                    'data-form-collection-add-label-value' => 'Ajouter une question', // Étiquette pour ajouter de nouvelles questions
                    'data-form-collection-delete-label-value' => 'Supprimer une question' // Étiquette pour supprimer des questions
                ]
            ])
            // Ajoute un bouton de soumission
            ->add('submit', ButtonType::class, [
                'label' => 'Submit', // Définit l'étiquette du bouton
                'attr' => [
                    'class' => 'btn btn-primary', // Ajoute des attributs supplémentaires si nécessaire
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Définit la classe de données par défaut pour le formulaire
        // Attention, il y a une erreur ici, 'data_class' ne peut être défini qu'une seule fois
        $resolver->setDefaults([
            'data_class' => Quiz::class,
            'data_class' => Score::class,
        ]);
    }
}
