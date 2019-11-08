<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\Movement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* campo con un nombre distinto a la property y 'mapped'=>false para evitar
            un error (invalid argument exception) y hacer funcionar la validacion.
            Ver asignacion en el controlador
            */
            ->add('formdate', DateType::class, [
                'label' => 'Invoiced at',
                'mapped' => false,
                'widget'=>'single_text',
                'input' => 'datetime',
                'html5' => 'false',
                'constraints' => [new NotBlank(['message'=>'Pick a date!'])],
            ])
            ->add('number')
            ->add('details')
            ->add('received_by', ChoiceType::class, [
                'choices' => [
                    'Diego' => 'diego',
                    'Pablo' => 'pablo',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('payed_at', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('movements', EntityType::class, [
                'class' => Movement::class,
                'expanded' => true,
                'multiple' => true,
                'constraints' => [new NotBlank(['message'=>'Pick a movement!'])],
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
