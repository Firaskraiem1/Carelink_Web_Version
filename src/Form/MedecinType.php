<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Specialite; // Corrected class name to start with an uppercase letter
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomDeCabinet')
            ->add('tel')
            ->add('adresse')
            ->add('email')
            ->add('heures')
            ->add('licenceMedicalId')
            // Add file upload field for image path profile
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
