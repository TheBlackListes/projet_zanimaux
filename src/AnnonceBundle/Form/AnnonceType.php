<?php

namespace AnnonceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
        'choices' => array(
            'Gardre des animaux' => 'Garde des animaux',
            'publicité de perdu' => 'publicité de perdu',

        )
    ))
            ->add('cause', ChoiceType::class, array(
                'choices' => array(
                    'gareder des animaus au domicile du pet-sitter' => '1',
                    'gareder des animaus à mon domicile' => '2',
                    'Promenade des animaux' => '3',

                )
            ))
            ->add('titre')
            ->add('description')
            ->add('region')
            ->add('date')
            ->add('tel')
            ->add('periode')

            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AnnonceBundle\Entity\Annonce',
            'csrf_protection'=> false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'annoncebundle_annonce';
    }


}
