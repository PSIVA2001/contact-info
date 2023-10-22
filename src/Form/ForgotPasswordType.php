<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ForgotPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add(
        'plainpassword',
        RepeatedType::class,
        [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password!',
                ]),
            ],

            'type' => PasswordType::class,
            'invalid_message' => 'The new password fields must match.',
            'first_options' => [
                'label' => 'New Password',
                'attr' => [
                    'class' => 'form-control form-control-user'
                ],
            ],
            'second_options' => [
                'label' => 'Confirm New Password',
                'attr' => [
                    'class' => 'form-control form-control-user'
                ],
            ]

        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}