<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajoute un champ pour le texte de la question
        $builder
            ->add('text', TextType::class, [
                'label' => 'Question' // Étiquette pour le champ du texte de la question
            ])
            // Ajoute une collection de champs de réponse
            ->add('answers', CollectionType::class, [
                'entry_type' => AnswerType::class, // Type de chaque élément de la collection
                'allow_add' => true, // Autorise l'ajout de nouveaux champs de réponse
                'allow_delete' => true, // Autorise la suppression des champs de réponse existants
                'by_reference' => false, // Passe chaque réponse en tant que référence d'objet
                'entry_options' => ['label' => false], // Masque les étiquettes pour chaque champ de réponse
                'attr' => [
                    'data-controller' => 'form-collection', // Définit un contrôleur de formulaire pour gérer les collections
                    'data-form-collection-add-label-value' => 'Ajouter une réponse', // Étiquette pour ajouter de nouvelles réponses
                    'data-form-collection-delete-label-value' => 'Supprimer une réponse' // Étiquette pour supprimer des réponses
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Définit la classe de données par défaut pour le formulaire
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
