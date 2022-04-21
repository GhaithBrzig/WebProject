<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Reservation;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomclient')
            ->add('numero')
            ->add('nbpersonne')
            ->add('date', DateType::class, [
                'widget' => "single_text",


            ])
            ->add('idEvenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'type',
                'multiple' => false,
                'expanded' => false,

            ])
            ->add("Save" , SubmitType::class,
            ['attr'=>['formnovalidate'=>'formnovalidate']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
