<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Lesson;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title') // Champ pour le titre de la leçon
            ->add('transcription') // Champ pour la transcription de la leçon
            ->add('src') // Champ pour la source de la leçon
            ->add('language', EntityType::class, [ // Champ pour sélectionner la langue de la leçon
                'class' => Language::class, // Entité associée au champ
                'choice_label' => 'id', // Propriété de l'entité à afficher comme libellé dans le champ (dans ce cas, l'ID)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class, // Classe d'entité associée au formulaire
        ]);
    }
}
