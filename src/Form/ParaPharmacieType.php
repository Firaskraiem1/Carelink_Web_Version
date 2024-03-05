<?php

namespace App\Form;

use App\Entity\ParaPharmacie;
use App\Entity\Zone;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ParaPharmacieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPara')
            ->add('email')
            ->add('nbrPharmaciens')
            ->add('numtel')
            ->add('latitude')
            ->add('longitude')
            ->add('typePara', ChoiceType::class, [
                'choices' => [
                    'Jour' => 'jour',
                    'Nuit' => 'nuit',
                ],
                'label' => 'Type de parapharmacie',
            ])
            ->add('horraire_ouverture')
            ->add('horraire_fermeture')
            ->add('imageFile',VichImageType::class)
            ->add('imageName', TextType::class)
            ->add('ville', EntityType::class, [
                'class' => Zone::class,
'choice_label' => 'ville',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParaPharmacie::class,
        ]);
    }
}
