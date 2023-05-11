<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarBookingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pickUpDate', DateType::class)
            //->add('returnDate', DateType::class)
            ->add('driverAge', IntegerType::class, [
                'attr' => ['placeholder' => 18],
            ])

            ->add('driverLicenseNumber', NumberType::class, [
                'attr' => ['placeholder' => 99999999],
            ])
            /*->add('car')*/
            ->add('confirm', SubmitType::class, ['attr' => ['class' => 'auth-submit']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
