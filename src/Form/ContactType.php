<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Mr' => 'Mr',
                    'Miss' => 'Miss'
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
                    'placeholder' => 'Lastname',
                ],
                'label' => 'Last Name',
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
            ->add('contactnumber', TextType::class, [
                'attr' => [
                    'placeholder' => 'Contact Number',
                ],
                'label' => 'Contact Number',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter mobile number!'
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Your mobile number cannot contain a alphabets!'
                    ]),
                    new Length([
                        'min' => 7,
                        'minMessage' => 'Your number should be correct!',
                        'max' => 15,
                    ])
                ]

            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'address',
                ],
                'label' => 'Address',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your address!'
                    ]),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Maximum length of address should only be {{ limit }} characters! '
                    ])
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Create'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
