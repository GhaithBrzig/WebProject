<?php

namespace App\Form;

use App\Entity\Repa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditRepaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder
            ->add('lib_prod',TextType::class , array(
                'label' => 'Product Name',
                'attr' => array( 
                    'class' => 'form-control validate'

                )
            ))
            ->add('description',TextareaType::class, array(
                'label' => 'Description',
                'attr' => array( 
                    'class' => 'form-control validate',
                    'row' => '3'

                )
                ))
            ->add('prix_prod',NumberType::class , array(
                'label' => 'Price',
                'html5' => true,
                'attr' => array( 
                    'class' => 'form-control validate'

                )
            ))
            ->add('quantite_dispo',NumberType::class , array(
                'label' => 'Units in stock',
                'html5' => true,
                'attr' => array( 
                    'class' => 'form-control validate'

                )
            ))
            ->add('remise',ChoiceType::class, array(
                'label' => 'Discount',
                'choices' => array(
                    '0%' => 1,
                    '20%' => 2,
                    '40%' => 3,
                    '60%' => 4,
                    '80%' => 5,
                ),
                'attr' => array(
                    'class' => 'custom-select tm-select-accounts'
                )
            ))

            
        ;

        $builder->setMethod('POST');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repa::class,
        ]);
    }
}
