<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('postcode')
            ->add('email')
            ->add('gasElectricityType')
            ->add('sameSupplier')
            ->add('energySupplier')
            ->add('plan')
            ->add('economyMeter')
            ->add('paymentType')
            ->add('planNotSure')
            ->add('gasMoneySpend')
            ->add('gasMoneyPerType')
            ->add('gasUseKWH')
            ->add('elecMoneySpend')
            ->add('elecMoneyPerType')
            ->add('elecUseKWH')
            ->add('chosenSupplier')
            ->add('personalInformation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
