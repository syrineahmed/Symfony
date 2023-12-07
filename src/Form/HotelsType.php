<?php

namespace App\Form;

use App\Entity\Hotels;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class HotelsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomHotel', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom de l\'hôtel ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Seules les lettres sont autorisées.',
                    ]),
                ],
            ])
            ->add('nbEtoile', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nombre d\'étoiles ne peut pas être vide.']),
                    new Range([
                        'min' => 0,
                        'max' => 5,
                        'minMessage' => 'Le nombre d\'étoiles doit être supérieur ou égal à {{ limit }}.',
                        'maxMessage' => 'Le nombre d\'étoiles doit être inférieur ou égal à {{ limit }}.',
                    ]),
                ],
            ])
            ->add('pays', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le pays ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Seules les lettres sont autorisées.',
                    ]),
                ],
            ])
            ->add('nbChambre', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nombre de chambres ne peut pas être vide.']),
                    new Range([
                        'min' => 0,
                        'minMessage' => 'Le nombre de chambres doit être un entier positif.',
                    ]),
                ],
            ])
            ->add('prixNuit', NumberType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le prix par nuit ne peut pas être vide.']),
                    new Range([
                        'min' => 0,
                        'minMessage' => 'Le prix par nuit doit être un nombre positif.',
                    ]),
                ],
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotels::class,
        ]);
    }
}
