<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\ReservationRdv;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservatioRdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_rdv')
            ->add('motif')
            ->add('remarques')
            //             ->add('patient', EntityType::class, [
            //                 'class' => Patient::class,
            // 'choice_label' => 'id',
            //             ])
            // ->add('medecin', EntityType::class, [
            //     'class' => Medecin::class,
            //     'choice_label' => 'nom',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationRdv::class,
        ]);
    }
}
