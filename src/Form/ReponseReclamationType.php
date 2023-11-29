<?php

namespace App\Form;

use App\Entity\ReponseReclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints as Assert;
class ReponseReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           /* ->add('sujet', TextareaType::class, [
                'label' => 'REPONSE:',
                'attr' => [
                    'style' => 'width: 200px; height: 100px',
                ],
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                // Remove 'readonly' attribute
            ])
            //->add('idReclamation')
            ->add('etat');*/
           ->add('sujet', TextareaType::class, [
               'attr' => ['rows' => 5],
               'constraints' => [
                   new Assert\NotBlank(),
                   new Assert\Length(['max' => 255]),
               ],
           ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Traitée' => 'traité',
                    'En cours de traitement' => 'non traite',
                ],
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            -> add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Date...'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new GreaterThanOrEqual('today'),
                ],
            ]);
        //->add('id_rec');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseReclamation::class,
        ]);
    }
}
