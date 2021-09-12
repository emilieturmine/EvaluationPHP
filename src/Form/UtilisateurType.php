<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'attr' => ['placeholder' => 'Votre adresse mail'], 'constraints' => [
                    new Regex([
                        'pattern' => '/#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#/',
                        'message' => 'adresse mail non valide'
                    ]),
                    'help' => 'Vous devez rentrer votre adresse mail ici',
                ]

            ])
            ->add('mdp', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'attr' => ['placeholder' => 'Votre mot de passe'], 'constraints' => [
                    new Regex([
                        'pattern' => '/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',
                        'message' => 'Vous devez rentrer un mot de passe valide'
                    ]),
                    'help' => 'doit contenir  huit caractères dont une lettre majuscule, un caractère spécial et des caractères alphanumériques ',
                ]

            ])
            ->add('confirm_mdp', PasswordType::class, [
                'label' => 'Confirmez votre mot de passe',
                'attr' => ['placeholder' => 'Confirmez votre mot de passe'], 'constraints' => [
                    new Regex([
                        'pattern' => '/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',
                        'message' => 'Vous devez rentrer un mot de passe valide'
                    ]),
                    'help' => 'doit contenir  huit caractères dont une lettre majuscule, un caractère spécial et des caractères alphanumériques ',
                ]

            ])
            ->add('role', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
