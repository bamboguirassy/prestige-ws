<?php

namespace App\Form;

use App\Entity\VenteProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prixUnitaire')
            ->add('quantite')
            ->add('montantTotal')
            ->add('produit')
            ->add('vente')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VenteProduit::class,
        ]);
    }
}
