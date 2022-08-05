<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',    
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Cette valeur ne doit pas être vide.']),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le titre doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],


            ])
            
            ->add('marque', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',    
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Cette valeur ne doit pas être vide.']),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'La marque doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'La marque ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],


            ])

            ->add('model', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',    
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Cette valeur ne doit pas être vide.']),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le model doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le model ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],


            ])
            
            ->add('description')
            
            ->add('imageFile', FileType::class, [
                'required' => false,
                //'data_class' => null,
                'mapped' => false,

            ])

            ->add('prix', MoneyType::class, [
                'required' => false,
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'text-info',    
                ],
                'attr' => [
                    'Placeholder' => 'saisir le prix',    
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Cette valeur ne doit pas être vide.']),
                ],

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
