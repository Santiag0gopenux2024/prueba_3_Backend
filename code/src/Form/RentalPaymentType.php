<?php

declare(strict_types=1);

namespace App\Form;

use App\Document\RentalPayment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalPaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lessee', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('property', EntityType::class, [
                'class' => LeaseContract::class,
                'choice_label' => 'propertyCode',
                'required' => true,
            ])
            ->add('paymentDate', DateType::class, ['widget' => 'single_text', 'required' => true])
            ->add('amount', NumberType::class, ['required' => true]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RentalPayment::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}