<?php

namespace App\Form;

use App\Entity\Vente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montantInitial')
            ->add('montantRegle')
            ->add('montantRestant')
            ->add('dateLivraison')
            ->add('adresseLivraison')
            ->add('livree')
            ->add('regle')
            ->add('dateLivraisonPrevue')
            ->add('dateLivraisonEffective')
            ->add('type')
            ->add('date')
            ->add('numeroVente')
            ->add('entreprise')
            ->add('agentVente')
            ->add('client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
