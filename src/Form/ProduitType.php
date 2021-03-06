<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\DomCrawler\Image;



class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'attr' => ['placeholder' => 'Reference du produit'], 'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-Z0-9_]*$/",
                        'message' => 'Caratère(s) non valide(s)'
                    ]),
                    'help' => 'Vous devez rentrer la reference du produit ici',
                ]

            ])
            ->add('libelle', TextType::class, [
                'attr' => ['placeholder' => 'Libelle du produit'], 'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-Z0-9_]*$/",
                        'message' => 'Caratère(s) non valide(s)'
                    ]),
                    'help' => 'Vous devez rentrer le libelle du produit ici',
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['placeholder' => 'Description du produit'], 'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9_]*$/',
                        'message' => 'Caratère(s) non valide(s)'
                    ]),
                    'help' => 'Vous devez rentrer la description du produit ici',
                ]
            ])
            ->add('prix', MoneyType::class, [
                'attr' => ['placeholder' => 'Prix du produit'], 'constraints' => [
                    new Regex([
                        'pattern' => '/[0-9]{1,}\.[0-9]{2}/',
                        'message' => 'Caratère(s) non valide(s)'
                    ]),
                    'help' => 'Vous devez rentrer le prix du produit ici',
                ]
            ])
            ->add('stock', IntegerType::class, [
                'attr' => ['placeholder' => 'Nombre de produit en stock'], 'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Caratère(s) non valide(s)'
                    ]),
                    'help' => 'Vous devez rentrer le prix du produit ici',
                ]
            ])
            ->add('couleur', TextType::class, [
                'attr' => ['placeholder' => 'Couleur du produit'], 'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-Z0-9_]*$/",
                        'message' => 'Caratère(s) non valide(s)'
                    ]),
                    'help' => 'Vous devez rentrer la couleur du produit ici',
                ]
            ])
            ->add('Photo2', FileType::class, [
                'label' => 'Photo du produit',
                //unmapped => fichier non associé à aucune propriété d'entité, validation impossible avec les annotations
                'mapped' => false,
                'required' => false,
                //'constraints' => [
                // new Image([
                // 'maxSize' => '2000k',

                //'mimeTypesMessage' => 'Veuillez insérer une photo au format jpg, jpeg ou png'
                // ])
                // ]
            ])
            ->add('Categorie', TextType::class, [
                'attr' => ['placeholder' => 'Categorie du produit'], 'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-zéèàçâêûîôäëüïö\_\-\s]+$/',
                        'message' => 'Caratère(s) non valide(s)'
                    ]),
                    'help' => 'Vous devez rentrer la categorie du produit ici',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
