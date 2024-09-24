<?php

namespace App\Form;

use App\Entity\Compagnie;
use PharIo\Manifest\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompagnieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder'=>"Nom de la compagnie", "autocomplete"=>"off"],
                'label' => "Nom *"
            ])
            ->add('dg', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder'=>"Nom du DG", 'auto complete'=>"off"],
                'label' => "Directeur Général",
                'required' => false
            ])
            ->add('representant', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder'=>"Nom du representant", 'autocomplete'=>"off"],
                'label' => "Representant *"
            ])
            ->add('contact', TelType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => "Coordonnées", 'autocomplete' => "off"],
                'label' => "Contact *"
            ])
            ->add('Email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder'=> "Adresse email", 'autocomplete' => "off"],
                'label' => "Email *"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compagnie::class,
        ]);
    }
}
