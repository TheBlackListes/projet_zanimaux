<?php

namespace AnimauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnimauxType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')

            ->add('type_animal', ChoiceType::class, array(
                'choices'  => array(
                    'Chien' => 'chien',
                    'Chat' => 'chat',
                    'Rongeur' => 'rongeur') ))

            ->add('race')

            ->add('sexe', ChoiceType::class, array(
                'choices'  => array(
                    'Mâle' => 'male',
                    'Femelle' => 'femelle') ))

            ->add('age')

            ->add('taille', ChoiceType::class, array(
                'choices'  => array(
                    'Petit' => 'petit',
                    'Moyen' => 'moyen',
                    'Grand' => 'grand') ))
            ->add('poids')
            ->add('description')
            ->add('energie')
            ->add('forceX')
            ->add('sociabilite')
            ->add('intelligence')
            ->add('photo')
            ->add('type_offre', ChoiceType::class, array(
                'choices'  => array(
                    'Vente' => 'vente',
                    'Adoption' => 'adoption') ))

            ->add('prix')
            ->add('proprietaire');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AnimauxBundle\Entity\Animaux'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'animauxbundle_animaux';
    }


}
