<?php

namespace App\Form;

use App\Entity\Adhesion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdhesionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference')
            ->add('civilite')
            ->add('nom')
            ->add('prenoms')
            ->add('fonction')
            ->add('entreprise')
            ->add('email')
            ->add('telephone')
            ->add('media')
            ->add('adresse')
            ->add('statut')
            ->add('slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adhesion::class,
        ]);
    }
}
