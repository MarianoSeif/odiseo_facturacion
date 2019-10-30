<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\Movement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget'=>'single_text',
            ])
            ->add('title')
            ->add('price')
            ->add('price_ars')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'revenue'=>'revenue',
                    'expense'=>'expense',
                ],
                'expanded'=>true,
                'multiple'=>false,
            ])
            ->add('invoices', null, [
                'expanded'=>'true',
                'multiple'=>'true',
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movement::class,
        ]);
    }
}
