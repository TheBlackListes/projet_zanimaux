<?php

namespace AnnonceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('titre')
            ->add('type', ChoiceType::class, array(
        'choices' => array(
            'Garde des animaux' => 'Garde des animaux',
            'Animal perdu' => 'Animal perdu',
            'Promenade des animaux' => 'Promenade des animaux',)))
            ->add('service',ChoiceType::class, array(
                'choices' => array(
                    'Offre' => 'Offre',
                    'Demande' => 'Demande', )))
            ->add('datePerdu',DateType::class,array('widget'=>'single_text','format'=>'yyyy-MM-dd'))
            ->add('dateAnnonce',DateType::class,array('widget'=>'single_text','format'=>'yyyy-MM-dd'))

            ->add('region')
            ->add('periode')
            ->add('description')
            ->add('image', FileType::class, array('data_class'=>null));

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
