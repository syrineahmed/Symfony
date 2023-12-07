<?php
// src/Form/UservolType.php

namespace App\Form;

use App\Entity\Uservol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UservolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usernom', TextType::class, [
                'label' => 'Nom de l\'utilisateur',
            ])
            ->add('userprenom', TextType::class, [
                'label' => 'Prénom de l\'utilisateur',
            ])
            ->add('numPassport', IntegerType::class, [
                'label' => 'Numéro de passeport',
            ])
            ->add('nomCompagnie', TextType::class, [
                'label' => 'Nom de la compagnie',
                'attr' => [
                    'readonly' => true,
                ],
            ])
            ->add('billetReservee', IntegerType::class, [
                'label' => 'Nombre de billets réservés',
            ])
            ->add('destination', TextType::class, [
                'label' => 'Destination',
                'attr' => [
                    'readonly' => true,
                ],
            ])
            ->add('dateDepart', TextType::class, [
                'label' => 'Date de départ',
                'attr' => [
                    'readonly' => true,
                ],
            ])
            ->add('factureVol', IntegerType::class, [
                'label' => 'Facture du vol',
                'disabled' => true,
            ])
           
            ->add('nbNuits', IntegerType::class, [
                'label' => 'Nombre de nuits',
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Uservol::class,
        ]);
    }
}
