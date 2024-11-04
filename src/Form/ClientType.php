<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
            ])
            ->add('adresse', TextareaType::class, [
                'attr' => [
                    'rows' => 3
                ],
                'required' => false,
            ])
            ->add('compte', UserType::class, [
                'label' => 'Informations du Compte',
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'bg-gray-800 text-white font-semibold py-2 px-4 rounded hover:bg-gray-700'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
