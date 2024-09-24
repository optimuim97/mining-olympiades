<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder'=>"Email", 'autocomplete'=>"off"]
            ])
            ->add('roles', ChoiceType::class,[
                'choices'=>[
                    'Administrateur' => 'ROLE_ADMIN',
                    'Coordinateur' => 'ROLE_COORDINATEUR',
                    'Utilisateur' => 'ROLE_USER'
                ],
                'multiple'=> true,
                'expanded'=>true,
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control', 'placeholder'=>"Mot de passe", 'autocomplete'=>"off"],
            ])
//            ->add('connexion')
//            ->add('lastConnectedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
