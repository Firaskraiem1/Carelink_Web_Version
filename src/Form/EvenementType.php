<?php

namespace App\Form;

use App\Entity\CategorieEvenement;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('idEvenement')
            ->add('titreEvenement')
            ->add('TypeEvenement')
            ->add('lieuEvenement')
            ->add('dateEvenement')
            ->add('descEvenement')
            ->add('idCatEvenement', EntityType::class, [
                'class' => CategorieEvenement::class,
                'choice_label' => 'nomCategorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
