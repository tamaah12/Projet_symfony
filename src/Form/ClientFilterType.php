<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'required' => false,
                'label' => 'Nom de famille'
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
                'label' => 'Téléphone'
            ])
            ->add('compte', ChoiceType::class, [
                'choices' => [
                    'Tous' => null,
                    'Avec compte' => true,
                    'Sans compte' => false,
                ],
                'required' => false,
                'label' => 'Statut du compte',
                'placeholder' => 'Sélectionner un statut',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
