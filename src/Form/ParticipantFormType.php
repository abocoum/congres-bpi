<?php

namespace App\Form;

use App\Entity\Civilite;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantFormType extends AbstractType
{

    const BPI = 100;
    const NBPI = 150;
    const GALA = 30;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('profession', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])   
            ->add('civilite', EntityType::class, [
                'class' => Civilite::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control']
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('province', TextType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('pays', CountryType::class, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('estMembreBpi', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
            ]])
            ->add('estPresentateur', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
            ]])
            ->add('titrePresentation', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('frais', ChoiceType::class, [
                'choices' => [
                    'F\'inscription au congrès pour les membres BPI / Frais d\'inscription au congrès pour devenir membre BPI - 100 Euros' => self::BPI,
                    'Frais d\'inscription au congrès pour les membres non-BPI - 150 euros' => self::NBPI,
                    'Frais supplémentaires - Dîner de gala - 30 Euro' => self::GALA,
                ],
                'expanded'  => true,
                'multiple'  => true,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mr-2'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
