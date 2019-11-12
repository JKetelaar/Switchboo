<?php

namespace App\Form;

use App\Entity\Quote;
use App\Service\SwitchManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteStepOneType extends AbstractType
{
    /**
     * @var SwitchManager
     */
    private $switchManager;

    /**
     * QuoteStepOneType constructor.
     * @param SwitchManager $switchManager
     */
    public function __construct(SwitchManager $switchManager)
    {
        $this->switchManager = $switchManager;
    }

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
                    'label' => 'What do you use at your home?',
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
                        'Find your supplier' => $options['suppliers'],
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
                        'Find your supplier' => $options['plans'],
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
                'suppliers' => [],
                'plans' => [],
            ]
        );
    }
}
