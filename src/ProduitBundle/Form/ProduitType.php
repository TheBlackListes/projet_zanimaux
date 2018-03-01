<?php

namespace ProduitBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('prix')
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Aliment' => 'Aliment',
                    'Accessoire' => 'Accessoire',)))

            ->add('etat', ChoiceType::class, array(
                'choices' => array(
                    'Disponible' => 'Disponible',
                    'Vendu' => 'Vendu',)))

            ->add('categorie', ChoiceType::class, array(
                'choices' => array(
                    'Chien' => 'Chien',
                    'Chat' => 'Chat',
                    'Autre' => 'Autre',)))

            ->add('marque')
            ->add('image', FileType::class, array('label' => 'Image'))
            ->add("Ajouter", SubmitType::class)

            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProduitBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'produitbundle_produit';
    }


}
