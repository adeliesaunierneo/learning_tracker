<?php

namespace App\Form;

use App\Entity\ExerciseAttempt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ExerciseAttemptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('answer', TextareaType::class, [
                'label'       => 'Ta réponse',
                'required'    => false,
                'attr'        => [
                    'rows'        => 8,
                    'placeholder' => 'Écris ta requête SQL ou ton code PHP ici...',
                ],
            ])
            ->add('isCorrect', ChoiceType::class, [
                'label'    => 'Comment tu t\'en es sortie ?',
                'required' => false,
                'expanded' => true,  // affiche des radio buttons
                'multiple' => false,
                'choices'  => [
                    'J\'ai réussi'  => true,
                    'Pas encore'    => false,
                ],
            ])
            ->add('notes', TextareaType::class, [
                'label'    => 'Tes notes personnelles',
                'required' => false,
                'attr'     => [
                    'rows'        => 3,
                    'placeholder' => 'Points que tu veux retenir, difficultés rencontrées...',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => ExerciseAttempt::class,
                               ]);
    }
}
