<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Moyen;
use App\Entity\Rapport;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportBordType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        isset($options['service']) ? $service = $options['service'] : $service = "ulam35";

        $builder
            ->add('dateMission', DateType::class, ['required' => true, 'label' => "Date de la mission"])
            ->add('typeRapport', ChoiceType::class, [
                'choices' => ['Ciblé' => 0, 'Ciblé manuellement' => 1, 'Aléatoire' => 2, 'Opportunité' => 3],
                'multiple' => false,
                'expanded' => false,
                'placeholder' => '',
                'label' => "Type de contrôle"])
            ->add('agents', EntityType::class, [
                'class' => Agent::class,
                'query_builder' => function (EntityRepository $er) use ( $service ) {
                    return $er->createQueryBuilder('a')
                        ->where('a.service = :service')
                        ->setParameter("service", $service)
                        ;
                },
                'multiple' => true,
                'expanded' => true,
                'label' => "Agents embauchés sur la mission"])
            ->add('typeMission', ChoiceType::class, [
                'choices' => [
                    'Visite de sécurité' => 0,
                    'Contrôle de navire(s)' => 1,
                    'Surveillance d\'aire marine'=> 2],
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'placeholder' => '',
                'label' => "Type de mission"])
            ->add('aireMarineSpeciale', ChoiceType::class, [
                'choices' => ['Aire marine protégée' => 0, 'DPM ou contrôle d\'AOT du DPM' => 1],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'placeholder' => '',
                'label' => "Aire marine spécifique"])
            ->add('lieuMission', ChoiceType::class, [
                'choices' => ['Mer' => 0, 'Terre' => 1],
                'multiple' => false,
                'expanded' => false,
                'placeholder' => '',
                'label' => "Lieu de la mission"])
            ->add('zoneMission', ChoiceType::class, [
                'choices' => ['Rade LO' => 0, 'Groix et courreaux' => 1, 'Rives Etel' => 2, 'Ouest Quiberon' => 3],
                'multiple' => false,
                'expanded' => false,
                'placeholder' => '',
                'label' => "Zone de la mission"])
            ->add('arme', CheckboxType::class, [
                'required' => false,
                'label' => "Mission armée ?"])
            ->add('dureeMission', IntegerType::class, [
                'required' => true,
                'label' => "Durée de la mission (en minutes)"])
            ->add('moyens', EntityType::class, [
                'class' => Moyen::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er) use ($service) {
                return $er->createQueryBuilder('m')
                    ->where('m.possesseur = :service')
                    ->setParameter("service", $service)
                    ;
                },
                'multiple' => true,
                'expanded' => true,
                'label' => "Moyens utilisés"])
            ->add('distanceTerrestre', IntegerType::class, [
                'required' => false,
                'label' => "Distance parcourue par véhicule (si pertinent)"])
            ->add('navires', CollectionType::class, [
                'entry_type' => SimpleRapportNavireType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('commentaire', null, [
                'label' => "Commentaires et remarques (pour note interne)"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
            'service' => "ulam35",
        ]);
    }
}
