<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Report;
use App\Entity\Shop;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                'attr'=>array(
                    'placeholder' => 'e.g. My laptop is broken'
                ),
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
                'attr'=>array(
                    'placeholder' => 'mymagentoteacherbeatsme123@gmail.com'
                ),
                'constraints' => [new Email([
                    'mode' => 'strict'
                ])],
            ])
            ->add('phone_number',  TextType::class, [
                'required' => false,
                'attr'=>array(
                    'placeholder' => '123456789'
                ),
                'constraints' =>[
                    new Regex([
                            'pattern' => "/^\d{9}$/",
                            'message' => "Phone number must contain excatly 9 digits"
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
