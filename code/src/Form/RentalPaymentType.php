<?php

declare(strict_types=1);

namespace App\Form;

use App\Document\LeaseContract;
use App\Document\RentalPayment;
use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalPaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lessee', DocumentType::class, [
                'class' => User::class,
            ])
            ->add('property', DocumentType::class, [
                'class' => LeaseContract::class,
            ])
            ->add('paymentDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
            ]);
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