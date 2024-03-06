<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Model\SearchMedecin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'nom du médecin']
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'placeholder' => 'spécialité du médecin',
                'choice_label' =>  'specialite',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchMedecin::class,
            'method' => 'GET'
        ]);
    }
}
