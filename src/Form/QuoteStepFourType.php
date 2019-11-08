<?php

namespace App\Form;

use App\Entity\PersonalInformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteStepFourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                ChoiceType::class,
                [
                    'choices' => [
                        'Mr.' => 'mr',
                        'Mrs.' => 'mrs',
                        'Miss.' => 'miss',
                    ],
                    'attr' => ['class' => 'form-control selector'],
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => ''], 'required' => true]
            )
            ->add(
                'surName',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => ''], 'required' => true]
            )
            ->add(
                'dateOfBirth',
                DateType::class,
                ['widget' => 'single_text', 'attr' => ['class' => 'form-control']]
            )
            ->add(
                'phoneNumber',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => ''], 'required' => true]
            )
            ->add(
                'address',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => ''], 'required' => true]
            )
            ->add('smartMeter')
            ->add('sameBilling')
            ->add(
                'specialRequirements',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => 'Not required'], 'required' => false]
            )
            ->add(
                'holdersName',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => ''], 'required' => true]
            )
            ->add(
                'sortCode',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => ''], 'required' => true]
            )
            ->add(
                'accountNumber',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => ''], 'required' => true]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => PersonalInformation::class,
            ]
        );
    }
}
