<?php

namespace App\Form;

use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class StockFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Name'
            ])
            ->add('unite', ChoiceType::class, [
                'label' => 'Unit',
                'choices' => [
                    'Kg' => 'Kg',
                    'Gram' => 'Gram',
                    'Litre' => 'Litre'
                ]
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantity',
                'html5' => true
            ])
            ->add('prixUnitaire', NumberType::class, [
                'label' => 'Unit Price',
                'html5' => true
            ])


            ->add('idCategorie', null, [
                'label' => 'category'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}