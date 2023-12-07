<?php

namespace App\Form;

use App\Entity\Vols;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class VolsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomAirways', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom de la compagnie aérienne ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Seules les lettres sont autorisées.',
                    ]),
                ],
            ])
            ->add('nbBillet', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nombre de billets ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Le nombre de billets doit être un nombre entier.',
                    ]),
                    new Range([
                        'min' => 0,
                        'minMessage' => 'Le nombre de billets doit être supérieur à zéro.',
                    ]),
                ],
            ])
            ->add('prixBillet', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le prix par nuit ne peut pas être vide.']),
                    new Range([
                        'min' => 0,
                        'minMessage' => 'Le prix par nuit doit être un nombre positif.',
                    ]),
                ],
            ])
            ->add('dateDepart', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'La date de départ ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^\d{4}\/\d{2}\/\d{2}$/',
                        'message' => 'Le format de la date de départ doit être "aaaa/mm/jj".',
                    ]),
                ],
            ])
            ->add('destination', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'La destination ne peut pas être vide.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vols::class,
        ]);
    }
}
