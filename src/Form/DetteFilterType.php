<?php

namespace App\Form;

use App\Entity\Client; // Assurez-vous d'importer l'entité Client
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Importer EntityType
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType; // Pour le champ de date
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Pour le champ de choix
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetteFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'surname', // Assurez-vous que c'est l'attribut que vous souhaitez afficher
                'required' => false,
                'placeholder' => 'Sélectionner un client',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text', // Assurez-vous que le widget de date est correct
                'required' => false,
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Soldé' => 'soldé',
                    'Non Soldé' => 'non soldé',
                ],
                'required' => false,
                'placeholder' => 'Sélectionner un statut',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Si vous n'utilisez pas d'entité pour ce formulaire
        ]);
    }
}
