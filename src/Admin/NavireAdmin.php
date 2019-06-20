<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NavireAdmin extends AbstractAdmin {
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('nom', TextType::class)
            ->add('immatriculation_fr', TextType::class)
            ->add('longueurHorsTout', NumberType::class)
            ->add('typeUsage', ChoiceType::class, [
                'choices' => [
                    'Pêche professionnelle' => 0,
                    'Conchylicole' => 1,
                    'Navire école' => 2,
                    'Commerce à passager' => 3,
                    'Pêche dormant' => 4,
                    'Plaisance professionnelle' => 5,
                    'Plaisance non professionnelle' => 6]])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('nom')
            ->add('immatriculation_fr')
            ->add('longueurHorsTout')
            ->add('typeUsage')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('nom')
            ->addIdentifier('immatriculation_fr')
            ->addIdentifier('longueurHorsTout')
            ->addIdentifier('typeUsage')
        ;
    }

}