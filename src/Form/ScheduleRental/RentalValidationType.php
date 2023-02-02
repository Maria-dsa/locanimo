<?php

namespace App\Form\ScheduleRental;

use App\Entity\ScheduleRental;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    'Choisissez le statut' => '',
                    'Réservation acceptée' => 'accepted',
                    'Réservation refusée' => 'rejected',
                    'Réservation annulée' => 'cancelledByO',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ScheduleRental::class,
        ]);
    }
}
