<?php
/**
 * Created by PhpStorm.
 * User: houss
 * Date: 2/18/2018
 * Time: 12:06 PM
 */

namespace EvenementBundle\Repository;
use Doctrine\ORM\EntityRepository;


class EvenementRepository extends EntityRepository
{
public  function afficherevenementUser($id_user)
{
    $query= $this->getEntityManager()
        ->createQuery("select m from EvenementBundle:Evenement m WHERE m.id_membre=:id_user")
        ->setParameter('id_user',$id_user)
    ;
    return $query->getResult();
}

    public  function findbest()
    {
        $query= $this->getEntityManager()
            ->createQuery("select m from EvenementBundle:Evenement m WHERE m.nbrParticipant>0   ORDER BY m.nbrParticipant DESC ")

        ;
        return $query->getResult();
    }


    public function findNom($nom)
    {
        $query= $this->getEntityManager()
            ->createQuery("select m from EvenementBundle:Evenement m WHERE m.nom like :nom")
            ->setParameter('nom',$nom)
        ;
        return $query->getResult();

    }




}