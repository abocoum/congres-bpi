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
                'attr' => ['class' => 'form-control']
            ])
            ->add('galaOption', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
            ]])
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
