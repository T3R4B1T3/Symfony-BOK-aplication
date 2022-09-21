<?php

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label'=>'Street and Number',
                'attr'=>array(
                    'placeholder'=>'e.g. Sczecińska 58'
                )
        ])
            ->add('City',TextType::class,[
                'attr'=>array(
                    'placeholder'=>'e.g. Słupsk'
                )
            ])
            ->add('PostCode',TextType::class,[
                'attr'=>array(
                    'placeholder'=>'e.g. 76-200'
                )
            ])
            ->add('PhoneNumber',TextType::class,[
                'attr'=>array(
                    'placeholder'=>'e.g. 444-888-777'
                )
            ])
            ->add('Region',TextType::class,[
                'attr'=>array(
                    'placeholder'=>'e.g. Pomorskie'
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
