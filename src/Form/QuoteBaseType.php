<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'postcode',
                TextType::class,
                ['attr' => ['placeholder' => 'YOUR POSTCODE', 'class' => 'form-control']]
            )
            ->add(
                'email',
                EmailType::class,
                ['attr' => ['placeholder' => 'YOUR EMAIL', 'class' => 'form-control']]
            )
            ->add(
                'submit',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-primary white-underline'], 'label' => 'CHECK MY ENERGY']
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
