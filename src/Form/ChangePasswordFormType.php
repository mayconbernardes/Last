<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.', // Message affiché en cas de mots de passe non correspondants
                'required' => true, // Le champ est requis
                'first_options'  => ['label' => 'Nouveau mot de passe'], // Libellé du premier champ de saisie
                'second_options' => ['label' => 'Répéter le mot de passe'], // Libellé du deuxième champ de saisie
                'mapped' => false, // Ne mappez pas ce champ avec une propriété de l'entité
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.', // Message affiché en cas de champ vide
                    ]),
                    new Length([
                        'min' => 12,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.', // Message affiché si le mot de passe est trop court
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^A-Za-z0-9]).{12,}$/', // Expression régulière pour les exigences de mot de passe
                        'message' => 'Veuillez vérifier que votre mot de passe respecte les conditions nécessaires.', // Message affiché si le mot de passe ne respecte pas les conditions
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
