<?php

namespace App\Form;

use App\Entity\FichePatient;
use App\Entity\Patient;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichePatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('relationPatient', EntityType::class, [
                'class' => Patient::class,
                'placeholder' => 'selectionner un patient',
                'choice_label' =>  function ($patient) {
                    return $patient->getPrenomP() . ' ' . $patient->getNomP();
                },
            ])
            ->add('adresse')
            ->add('Code_Postal')
            ->add('Ville')
            ->add('date_naissance', DateType::class, [
                'input' => 'datetime',
                'format' => 'yyyy-MM-dd', // Format de date souhaité
            ])
            ->add('poids')
            ->add('taille')
            ->add('maladie');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichePatient::class,
        ]);
    }
}
