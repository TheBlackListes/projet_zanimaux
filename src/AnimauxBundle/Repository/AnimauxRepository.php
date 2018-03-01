<?php
/**
 * Created by PhpStorm.
 * User: Med Amine
 * Date: 13/02/2018
 * Time: 20:55
 */

namespace AnimauxBundle\Repository;
use Doctrine\ORM\EntityRepository;

class AnimauxRepository extends EntityRepository
{
    public function afficheAnimauxParOffre($type_offre)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                select m from AnimauxBundle:Animaux m WHERE m.type_offre=:type_offre
            ") ->setParameter('type_offre',$type_offre)
        ;
        return $query->getResult();
    }

    public function afficheAnimauxUser($id_user)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                select m from AnimauxBundle:Animaux m WHERE m.proprietaire=:id_user
            ") ->setParameter('id_user',$id_user)
        ;
        return $query->getResult();
    }

    public function findidDQL($id)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                select m from AnimauxBundle:Animaux m WHERE m.id=:id
            ") ->setParameter('id',$id)
        ;
        return $query->getResult();
    }

    public function afficheplusdate($type_offre)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                select m from AnimauxBundle:Animaux m WHERE m.type_offre=:type_offre ORDER BY m.date
            ") ->setParameter('type_offre',$type_offre)
        ;
        return $query->getResult();
    }


    public function affichemoinsdate($type_offre)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                select m from AnimauxBundle:Animaux m WHERE m.type_offre=:type_offre ORDER BY m.date DESC 
            ") ->setParameter('type_offre',$type_offre)
        ;
        return $query->getResult();
    }


}