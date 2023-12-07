<?php
// src/Form/UserhotelType.php

namespace App\Form;

use App\Entity\Userhotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Added this line
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class UserhotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userNom')
            ->add('userPrenom')
            ->add('numpassport')
            ->add('nomHotel', TextType::class, [
                'label' => 'Nom de l\'hôtel',
                'attr' => [
                    'readonly' => true, // This makes the field non-editable but still submitted
                ],
               // This makes the field not editable
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays',
                'attr' => [
                    'readonly' => true, // This makes the field non-editable but still submitted
                ],
                // This makes the field not editable
            ])
          
                // This makes the field not editable
        
            ->add('chambreReservee', IntegerType::class, [
                'label' => 'Nombre de chambres réservées',
            ])
            ->add('factureHotel', IntegerType::class, [
                'label' => 'Facture',
                'disabled' => true, // Render the field as non-editable
            ])
            ->add('nbNuits', IntegerType::class, [
                'label' => 'Nombre de nuits',
                'mapped' => false, // This field is not mapped to any property in the entity
            ]);
             // Ajoutez l'événement pour calculer la facture après la soumission du formulaire
    $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
        $form = $event->getForm();
        $userhotel = $event->getData();

        // Récupérer le prix par nuit depuis l'entité Hotels
        $nomHotel = $userhotel->getNomHotel();

        if ($nomHotel instanceof Hotels) {
            $prixNuit = $nomHotel->getPrixNuit();
        } else {
            // Gérer le cas où getNomHotel() ne renvoie pas un objet Hotels
            $prixNuit = 0; // ou une autre valeur par défaut
        }
        
        
        // Calculer la facture en fonction du nombre de nuits et du nombre de chambres réservées
        $nbChambres = $form->get('chambreReservee')->getData();
        $nbNuits = $form->get('nbNuits')->getData();
        $facture = $nbNuits * $nbChambres * $prixNuit;

        // Définir la facture dans l'entité Userhotel
        $userhotel->setFactureHotel($facture);
    });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Userhotel::class,
        ]);
    }
}
