<?php

namespace App\Form;

use App\Entity\CategorieProd;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('nom_prod')
            ->add('prix_prod')
            ->add('stock_prod')
            ->add('description')
            ->add('image', FileType::class, [
                'label' => 'Produit Image' ,
                'required' => false,
                'mapped' => false,
            ])
            ->add('id_C', EntityType::class, [
                'class' => CategorieProd::class,
'choice_label' => 'nom_categorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
