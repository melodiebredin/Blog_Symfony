<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title',TextType::class, [
            'label' => 'Titre',
            'required' => true,
            'attr' => ['placeholder' => 'Entrez un titre']
        ])
        ->add('subtitle',TextType::class, [
            'label' => 'Soustitre',
            'required' => true,
            'attr' => ['placeholder' => 'Entrez un soustitre'],
            'constraints' =>[
                new NotBlank([
                    'message'=>'Ce champ ne peut être vide'
                ]),
                new Length([
                    'min'=>3,
                    'max'=> 250,
                    'minMessage'=>'Le sous-titre doit comporter {{limit}} caractères au minimum.'

                ])
            ]

        ])
        ->add('description',TextareaType::class, [
            'label' => 'Description',
            'required' => true,
            'attr' => ['placeholder' => 'Entrez unse description']
        ])

        ->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'name',
            'label' => 'choisissez la categorie de larticle'
        ])
        ->add('picture',FileType::class, [
            'label' => 'Photo',
            'required' => true,
            'attr' => ['placeholder' => 'Entrez une illustration'],
            'constraints'=>[
                new Image([
                    'mimeTypes'=>['image/jpeg', 'image/jpeg'],
                    'mimeTypesMessage'=> 'Les types de fichier autorisés sont : .jpeg/ .png'
                ])
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => ['class' => 'btn btn-warning d-block mx-auto my-3 col-4']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,

            /*
            On rajoute 'allow_file_upload' (une clef d'une paire $key -> $value) 
            dans un array qui est un paramètre de symfony qu'on definit a true
            cela permet d'autorisé notre formulaire a importer des fichiers - >
            revien a  => revient à <form enctype=multipart/form-data>

            */

            'allow_file_upload' => true,
//            'picture' => null,
        ]);
    }
}
