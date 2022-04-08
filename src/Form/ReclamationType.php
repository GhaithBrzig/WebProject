<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;



class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomclient', null, [
                'label' => 'Your Name '
            ])
            ->add('emailclient', null, [
                'label' => 'Your Email '
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description ',
                'attr' => array('style' => 'height: 200px')
            ])
            ->add('date', HiddenType::class)
            ->add('issolved', HiddenType::class, [
                'data' => 0,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
