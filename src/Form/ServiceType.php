<?php

namespace App\Form;

use App\Entity\GestionCategories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomcategorie', TextType::class,[
                "attr"=>[
                    "class"=>"form-controller"
                ]
            ])
            ->add('description', TextType::class,[
                "attr" => [
                    "class" => "form-controller"
                ]
            ])
            ->add('tarification', TextType::class,[
                "attr" => [
                    "class" => "form-controller"
                ]
            ])
            ->add('refServices',ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Soin de santé mentale' => 'Soin de santé mentale',
                    'Soins cardiovasculaires' => 'Soins cardiovasculaires',
                    'Soins Dentaires Généraux' => 'Soins Dentaires Généraux',
                    'Soins Esthétiques Dentaires' => 'Soins Esthétiques Dentaires',
                ],
                'label' => 'Ref_Services',
                'placeholder' => 'Sélectionnez une réference',
            ])
            ->add('disponibilite',ChoiceType::class, [
                'choices' => [
                    'disponible' => 'disponible',
                    'indisponible' => 'indisponible',
                ],
                'label' => 'Disponibilité',
                'expanded' => true,  // Cela rendra les choix affichés en tant que boutons radio
                'multiple' => false, // Vous pouvez choisir plusieurs options si vous le souhaitez

            ])
            ->add('date', TextType::class,[
                "attr" => [
                    "class" => "form-controller"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GestionCategories::class,
        ]);
    }
}
