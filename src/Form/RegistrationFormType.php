<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
// use Symfony\Component\Validator\Constraints\Length;
// use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email') // Champ pour l'email de l'utilisateur
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devriez accepter nos conditions.', // Message si l'utilisateur ne coche pas la case
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'], // Attribut pour désactiver l'autocomplétion
                'constraints' => [
                    // new NotBlank([
                    //     'message' => 'Please enter a password',
                    // ]),
                    // new Length([
                    //     'min' => 8,
                    //     'minMessage' => 'Votre mot de passe doit avoir au moins {{ limit }} characters',
                    //     // max length allowed by Symfony for security reasons
                    //     'max' => 30,
                    // ]),

                    // Remplace the previous method for the following

                    // Au moins une majuscule, (?=.*?[A-Z])
                    // Au moins une minuscule, (?=.*?[a-z])
                    // Au moins un chiffre, (?=.*?[0-9])
                    // Au moins un caractère spécial, c'est-à-dire n'importe quel caractère non inclus dans les 3 premières conditions, (?=.*?[^A-Za-z0-9])
                    // Minimum douze caractères de longueur .{12,}
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^A-Za-z0-9]).{12,}$/', "Veuillez vérifier que votre mot de passe respecte les conditions nécessaires")  
                  
                ],
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
