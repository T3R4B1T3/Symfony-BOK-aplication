<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Report;
use App\Entity\Shop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('email')
            ->add('phone_number')
            ->add('category',  EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('shop',EntityType::class, [
                'class' => Shop::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
    }
}
