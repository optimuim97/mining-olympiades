<?php

namespace App\Form;

use App\Entity\Discipline;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisciplineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>"off", 'placeholder'=>"Titre"]
            ])
            ->add('joueur', IntegerType::class,[
                'attr'=>['class'=>'form-control', 'autocomplete'=>"off", 'placeholder'=>"Nombre de joueurs"]
            ])
            ->add('complementaire', CheckboxType::class,[
                'required' => false,
                'label' => "Concerné(e) par le choix complémentaire",
                'attr' => ['class' => 'form-check-input']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Discipline::class,
        ]);
    }
}
