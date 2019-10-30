<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class DesdeHastaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('desde', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime',
                'placeholder' => 'desde',
                'constraints' => [new NotBlank(['message'=>'Pick a date!'])],
                ])
            ->add('hasta', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime',
                'placeholder' => 'hasta',
                'constraints' => [new NotBlank(['message'=>'Pick a date!'])],
                ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
