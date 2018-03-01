<?php
/**
 * Created by PhpStorm.
 * User: houss
 * Date: 2/24/2018
 * Time: 12:02 PM
 */

namespace EvenementBundle\Repository;

namespace EvenementBundle\Repository;
use Doctrine\ORM\EntityRepository;


class ParticipationRepository extends EntityRepository

{
    public  function findparticipation($id_user,$id_evenement)
    {
        $query= $this->getEntityManager()
            ->createQuery("select m from EvenementBundle:Participation m WHERE m.id_user=:id_user AND m.id_evenement=:id_evenement")
            ->setParameter('id_user',$id_user)
            ->setParameter('id_evenement',$id_evenement)
        ;

        return $query->getResult();
    }

}