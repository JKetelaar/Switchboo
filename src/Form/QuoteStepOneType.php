<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteStepOneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'gasElectricityType',
                ChoiceType::class,
                [
                    'choices' => [
                        'Gas and Electricity' => '1',
                        'Gas only' => '2',
                        'Electricity only' => '3',
                    ],
                    'label' => 'What do you use at your home',
                    'expanded' => true,
                    'multiple' => false,
                    'choice_attr' => [
                        'class' => 'btn btn-primary',
                    ],
                ]
            )
            ->add('sameSupplier')
            ->add(
                'energySupplier',
                ChoiceType::class,
                [
                    'choices' => [
                        'Find your supplier' => [
                            'Supplier 1' => 1,
                            'Supplier 2' => 2,
                            'Supplier 3' => 3,
                        ],
                    ],
                    'attr' => [
                        'class' => 'form-control selector',
                    ],
                ]
            )
            ->add('energySupplierImage')
            ->add(
                'plan',
                ChoiceType::class,
                [
                    'choices' => [
                        'Select your plan' => [
                            'Plan 1' => 1,
                            'Plan 2' => 2,
                            'Plan 3' => 3,
                        ],
                    ],
                    'attr' => [
                        'class' => 'form-control selector',
                    ],
                ]
            )
            ->add('planNotSure')
            ->add('economyMeter')
            ->add(
                'submit',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-primary black-button'], 'label' => 'NEXT PAGE']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Quote::class,
                'csrf_protection' => false,
            ]
        );
    }
}
