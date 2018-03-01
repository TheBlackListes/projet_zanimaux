<?php
/**
 * Created by PhpStorm.
 * User: Med Amine
 * Date: 27/02/2018
 * Time: 11:01
 */

namespace AnimauxBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheBackIdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class)
            ->add('valider', SubmitType::class) ;
    }
    public function getName()
    {
        return 'id_recherche';
    }
}