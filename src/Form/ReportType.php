<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Report;
use App\Entity\Shop;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

class ReportType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
                'required' => true,
                'constraints' => [new Length([
                    'min' => 30,
                    'minMessage' => "Description requires at least 30 characters"]),
                    new Regex([
                        'pattern' => "/^[\w',]+\s[\w',]+\s[\w',]+/",
                        'message' => "Description requires at least 3 words"
                    ])],
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'constraints' => [new Email([
                    'mode' => 'strict'
                ])],
            ])
            ->add('phone_number', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex([
                            'pattern' => "/^\d{9}$/",
                            'message' => "Phone number must contain exactly 9 digits"
                        ]
                    )]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('shop', EntityType::class, [
                'class' => Shop::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
    }
}
