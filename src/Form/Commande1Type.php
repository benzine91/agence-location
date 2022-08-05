<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commande;
use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class Commande1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('startAt', DateTimeType::class, [
            'date_widget' => "single_text",
            "hours" => [0,15,30,45],
            "minutes" => [0,15,30,45],
            "label" => "Début"
        ])
        ->add('cmdAt', DateTimeType::class, [
            'date_widget' => "single_text",
            "hours" => [0,15,30,45],
            "minutes" => [0,15,30,45],
            "label" => "Fin"
        ])
         ->add('User', EntityType::class, [ // définir que cet élément est une relation
            "class" => User::class,         // relation avec quelle class
            "choice_label" => "email",      // quelle propriété de la class à faire apparaître sur le navigateur
            //"expanded" => true
         ])

         ->add('vehicule', EntityType::class, [
            'class' => Vehicule::class,
            //"choice_label" => 'titre'
            "choice_label" => function($objet){
                return $objet->getTitre() . " " . $objet->getMarque() . " " . $objet->getModel();
            }
         ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
