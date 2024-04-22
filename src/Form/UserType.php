<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email') // Champ pour l'email de l'utilisateur
            ->add('roles') // Champ pour les rôles de l'utilisateur
            ->add('password') // Champ pour le mot de passe de l'utilisateur
            ->add('user', EntityType::class, [ // Champ pour lier l'utilisateur à une leçon
                'class' => Lesson::class, // Entité cible
                'choice_label' => 'id', // Champ utilisé comme libellé dans la liste déroulante
                'multiple' => true, // Autoriser la sélection de plusieurs leçons
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
