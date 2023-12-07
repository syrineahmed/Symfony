<?php

namespace App\Form;

use App\Entity\Medecin;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Only letters are allowed.',
                ]),
            ],
        ])
        ->add('prenom', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Only letters are allowed.',
                ]),
            ],
        ])
        ->add('specialite', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Only letters are allowed.',
                ]),
            ],
        ])
        ->add('pays', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Only letters are allowed.',
                ]),
            ],
        ])
            ->add('dategrad', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('numbergrad', TextType::class)
            ->add('email', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'message' => 'Invalid email address.',
                    ]),
                ],
            ])
            ->add('motdepasse', PasswordType::class)
            ->add('Enregistrer', SubmitType::class, [
                'label' => 'SignIn', // Consider using a translation key
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}