<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteStepTwoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'paymentType',
                ChoiceType::class,
                [
                    'choices' => $options['payment_methods'],
                    'attr' => [
                        'class' => 'form-control selector',
                    ],
                ]
            )
            ->add(
                'gasMoneySpend',
                NumberType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => '£'], 'required' => false]
            )
            ->add(
                'gasMoneyPerType',
                ChoiceType::class,
                [
                    'choices' => [
                        'Week' => 'week',
                        'Month' => 'month',
                        'Year' => 'year',
                    ],
                    'attr' => ['class' => 'form-control selector'],
                    'required' => false,
                ]
            )
            ->add(
                'gasUseKWH',
                NumberType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => 'kWH'], 'required' => false]
            )
            ->add(
                'elecMoneySpend',
                NumberType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => '£'], 'required' => false]
            )
            ->add(
                'elecMoneyPerType',
                ChoiceType::class,
                [
                    'choices' => [
                        'Week' => 'week',
                        'Month' => 'month',
                        'Year' => 'year',
                    ],
                    'attr' => ['class' => 'form-control selector'],
                    'required' => false,
                ]
            )
            ->add(
                'elecUseKWH',
                NumberType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => 'kWH'], 'required' => false]
            )
            ->add(
                'phoneNumber',
                TextType::class,
                ['attr' => ['class' => 'form-control', 'placeholder' => 'Phone number']]
            )
            ->add('selectedGasSpend')
            ->add('selectedElecSpend')
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
                'payment_methods' => [],
                'allow_extra_fields' => true,
            ]
        );
    }
}
