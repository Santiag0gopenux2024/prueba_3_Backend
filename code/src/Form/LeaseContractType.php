<?php

declare(strict_types=1);

namespace App\Form;

use App\Document\LeaseContract;
use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeaseContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lessee', DocumentType::class, [
                'class' => User::class
            ])
            ->add('monthlyRentAmount', NumberType::class)
            ->add('propertyCode', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LeaseContract::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}