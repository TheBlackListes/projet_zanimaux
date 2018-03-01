<?php

namespace AnimauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use blackknight467\StarRatingBundle\Form\RatingType;


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

            ->add('age', ChoiceType::class, array(
                'choices'  => array(
                    'Jeune' => 'jeune',
                    'Adulte' => 'adulte') ))

            ->add('description')

            ->add('energie', RatingType::class, ['stars' => 5,])
            ->add('forceX', RatingType::class, ['stars' => 5,])
            ->add('sociabilite', RatingType::class, ['stars' => 5,])
            ->add('intelligence', RatingType::class, ['stars' => 5,])

            ->add('photo' ,FileType::class,array('data_class'=>null))

            ->add('type_offre', ChoiceType::class, array(
                'choices'  => array(
                    'Vente' => 'vente',
                    'Adoption' => 'adoption') ))

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
