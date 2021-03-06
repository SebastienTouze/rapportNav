<?php

namespace App\Form;

use App\Entity\ActiviteFormation;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteFormationType extends ActiviteType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        $builder
            ->add('formation', TextareaType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('formateur', CheckboxType::class, [
                'required' => false,
                'label' => null
                ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ActiviteFormation::class,
            'service' => "",
        ]);
    }
}
