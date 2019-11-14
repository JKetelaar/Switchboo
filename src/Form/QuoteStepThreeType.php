<?php

namespace App\Form;

use App\Entity\API\FutureSupply;
use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteStepThreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $suppliers = [];
        /** @var FutureSupply $supplier */
        foreach ($options['suppliers'] as $supplier) {
            $suppliers[$supplier->getSupplier()] = $supplier->getSupplierId();
        }

        $builder
            ->add(
                'chosenSupplier',
                ChoiceType::class,
                [
                    'choices' => $suppliers,
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                ['attr' => ['class' => 'btn btn-primary black-button'], 'label' => 'SWITCH NOW']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Quote::class,
                'csrf_protection' => false,
                'suppliers' => [],
            ]
        );
    }
}
