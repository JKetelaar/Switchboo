<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                    'choices' => [
                        'PayPal' => 'paypal',
                        'CreditCard' => 'creditcard',
                    ],
                    'attr' => [
                        'class' => 'form-control selector',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Quote::class,
            ]
        );
    }
}
