<?php
/**
 * Created by PhpStorm.
 * User: yahya
 * Date: 24/02/2018
 * Time: 16:07
 */



namespace AppBundle\Repository ;
use Doctrine\ORM\EntityRepository ;




class UserRepository extends EntityRepository
{



    public function findNom($nom)
    {
        $q=$this->createQueryBuilder('m')
            ->where('m.username LIKE :username')
            ->setParameter(':username',"%$nom%");
        return $q->getQuery()->getResult();
    }












}