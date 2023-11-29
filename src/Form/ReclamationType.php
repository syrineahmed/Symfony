<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Exception\InvalidEmailException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints as Assert;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           /* ->add('sujet')
            ->add('email')
            ->add('description')
            //->add('etat')
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['readonly' => true],
            ])*/
           ->add('sujet', ChoiceType::class, [
               'choices' => [
                   'Services' => 'Services',
                   'Medecin' => 'Medecin',
               ],
               'expanded' => false,
               'multiple' => false,
               'constraints' => [
                   new Assert\NotBlank(),
               ],
           ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email([
                        'message' => 'The email "{{ value }}" is not a valid email.',
                        'normalizer' => function ($value) {
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                throw new InvalidEmailException();
                            }

                            return $value;
                        },
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 5 // nombre de lignes à afficher
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    //'Traitée' => 'traité',
                    'En cours de traitement' => 'non traite',
                ],
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Date...'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new GreaterThanOrEqual('today'),

                ],
            ])
            //->add('idUtilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
