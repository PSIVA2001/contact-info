<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [

                'attr' => [
                    'placeholder' => 'Username',
                ],
                'label' => 'Username',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your username!'
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Maximum length of username should only be {{ limit }} characters! '
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [

                'attr' => [
                    'placeholder' => 'Firstname',
                ],
                'label' => 'Firstname',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter first name!'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Please enter an alphabet character only!'
                    ]),
                    new Length([
                        'max' => 30,
                        'maxMessage' => 'Maximum length of first name should only be {{ limit }} characters! '
                    ])
                ]

            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'lastname',
                ],
                'label' => 'lastname',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter last name!'
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Please enter an alphabet character only!'
                    ]),
                    new Length([
                        'max' => 30,
                        'maxMessage' => 'Maximum length of last name should only be {{ limit }} characters! '
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a email address!'
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email address!'
                    ]),
                ]
            ])
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
                    ],
                    'second_options' => [
                        'label' => 'Confirm New Password',
                    ]

                ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
