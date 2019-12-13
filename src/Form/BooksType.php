<?php

namespace App\Form;

use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* Book Title */
            ->add('title', TextType::class, [
                'label' => "Titre du livre",
                'help' => "Saisir le titre du livre",
                'required' => true,
                'attr' => [
                    'placeholder' => "Titre du livre",
                    'class' => "form-control",
                ],
                'label_attr' => [
                    'class' => "col-4",
                ],
                'help_attr' => [
                    'class' => 'form-text text-muted',
                ],
            ])

            /* Book Description */
            ->add('description', TextareaType::class, [
                'label' => "Description du livre",
                'help' => "Saisir la description du livre",
                'required' => true,
                'attr' => [
                    'placeholder' => "Description du livre",
                    'class' => "form-control",
                ],
                'label_attr' => [
                    'class' => "col-4",
                ],
                'help_attr' => [
                    'class' => 'form-text text-muted',
                ],
            ])
            
            /* Book Price */
            ->add('price', NumberType::class, [
                'label' => "Prix du livre",
                'help' => "Saisir le prix du livre",
                'required' => true,
                'attr' => [
                    'placeholder' => "Prix du livre",
                    'class' => "form-control",
                ],
                'label_attr' => [
                    'class' => "col-4",
                ],
                'help_attr' => [
                    'class' => 'form-text text-muted',
                ],
            ])

            /* Book Cover */
            //->add('cover')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
