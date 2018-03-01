<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 27/02/2018
 * Time: 10:34
 */

namespace AnnonceBundle\Repository;
use Doctrine\ORM\EntityRepository;


class CommentaireRepository  extends EntityRepository
{

    public function rechCommentaire($id){


        $q=$this->getEntityManager()
            ->createQuery("select a from AnnonceBundle:Commentaire a
                               WHERE a.id_user=:id  ")
            ->setParameter('id',$id);
        return $q->getResult();
    }


}