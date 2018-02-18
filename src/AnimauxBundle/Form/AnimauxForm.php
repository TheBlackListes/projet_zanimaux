<?php

namespace AnimauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnimauxForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('type_animal')
            ->add('race')
            ->add('sexe')
            ->add('age')
            ->add('taille')
            ->add('poids')
            ->add('description')
            ->add('energie')
            ->add('forceX')
            ->add('sociabilite')
            ->add('intelligence')
            ->add('photo')
            ->add('type_offre')
            ->add('prix');
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
