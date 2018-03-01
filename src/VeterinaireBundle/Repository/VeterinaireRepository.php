<?php
/**
 * Created by PhpStorm.
 * User: Tritux
 * Date: 26/02/2018
 * Time: 17:20
 */

namespace VeterinaireBundle\Repository;



use Doctrine\ORM\EntityRepository;

class VeterinaireRepository extends EntityRepository
{
public function calculNbrNotes($id)
{
    $query=$this->getEntityManager()->createQuery("select COUNT(m) FROM  VeterinaireBundle:NoteVeterinaire m WHERE (m.idVeterinaire =:id)")
        ->setParameter('id',$id);
    return $query->getSingleScalarResult();
}

    public function calculSommeNotes($id)
    {
        $query=$this->getEntityManager()->createQuery("select SUM(m.note) FROM  VeterinaireBundle:NoteVeterinaire m WHERE (m.idVeterinaire =:id)")
            ->setParameter('id',$id);
        return $query->getSingleScalarResult();
    }

    public function troisPlusVeterinaireNoté ()
    {
     $querry=$this->getEntityManager()->createQuery("select m FROM VeterinaireBundle:Veterinaire m ORDER BY m.note")   ;
     return $querry->getResult();
    }
    public function findvet($nom)
    {
        $query=$this->getEntityManager()->createQuery("select m from VeterinaireBundle:Veterinaire m
where m.nom like :nom")->setParameter('nom','%'.$nom.'%');
        return $query->getResult();
    }
}