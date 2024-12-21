<?php

namespace App\Form;

use App\Entity\Dette;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', NumberType::class, [
                'label' => 'Montant',
            ])
            ->add('montantVerse', NumberType::class, [
                'label' => 'Montant Versé',
                'data' => 0
            ])
            ->add('dateAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'html5' => true,
                'input' => 'datetime_immutable',
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'surname',
                'label' => 'Client',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dette::class,
        ]);
    }
}
