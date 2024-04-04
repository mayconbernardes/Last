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
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devriez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
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

                    //At least one upper case, (?=.*?[A-Z])
                    // At least one lower case, (?=.*?[a-z])
                    // At least one digit, (?=.*?[0-9])
                    // At least one special character, that is any character not included on the first 3 conditions, (?=.*?[^A-Za-z0-9])
                    // Minimum eight in length .{8,}
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
