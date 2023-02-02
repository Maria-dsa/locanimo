<?php

namespace App\Form;

use App\Entity\Availablity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvailablityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Du',
            ])
            ->add('endedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Au',
            ])
            ->add('dailyPrice', null,[
                'label' => 'Prix par jour (€)',
        ])
            //->add('animal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Availablity::class,
        ]);
    }
}
