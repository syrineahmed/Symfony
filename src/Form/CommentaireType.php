<?php

namespace App\Form;

use App\Entity\Avisetcommentaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomService')
            ->add('idPatient', TextType::class,[
                "attr"=>[
                    "class"=>"form-controller"
                ],
            ])
            ->add('note', IntegerType::class, [
                'attr' => [
                    'class' => 'form-controller',
                ],
            ])
            ->add('commentaire'/*, TextType::class,[
                "attr"=>[
                    "class"=>"form-controller"
                ],

                'constraints' => [
                    new Callback([
                        'callback' => [$this, 'validateComment'],
                    ]),
                ],
            ]*/)
            ->add('dateAvis', TextType::class,[
                "attr"=>[
                    "class"=>"form-controller"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avisetcommentaires::class,
        ]);
    }
    public static function validateComment($comment, ExecutionContextInterface $context, ValidatorInterface $validator)
    {
        $inappropriateWords = ["word1", "word2", "word3", "word4"];

        foreach ($inappropriateWords as $word) {
            if (stripos($comment, $word) !== false) {
                $context->buildViolation('The comment contains inappropriate words.')
                    ->atPath('commentair')
                    ->addViolation();
            }
        }

        // You can also use the ValidatorInterface for additional validations
        $violations = $validator->validate($comment, new NotBlank());
        if (count($violations) > 0) {
            $context->buildViolation('The comment must not be empty.')
                ->atPath('commentair')
                ->addViolation();
        }
    }
}
