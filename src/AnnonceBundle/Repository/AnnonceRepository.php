<?php


namespace AnnonceBundle\Repository;
use Doctrine\ORM\EntityRepository;


class AnnonceRepository extends EntityRepository
{



    public function recherche($region,$periode,$service)
    {
        $query=$this->getEntityManager()
            ->createQuery('
            select m from AnnonceBundle:Annonce m 
            where m.region like :region AND m.periode like :periode AND m.service like :service')
            ->setParameter('region','%'.$region.'%')
            ->setParameter('periode','%'.$periode.'%')
            ->setParameter('service','%'.$service.'%');
        return $query->getResult();

    }






    public function afficherAnnonceUser($id_user)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.membre = :membre')->setParameter('membre', $id_user)
            ->andWhere('a.dateAnnonce >= :today')->setParameter('today', new \DateTime())
        ;

        $results = $qb->getQuery()->getResult();

        return $results;
    }



    public function mesAnnonceInactiveUser($id_user)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.membre = :membre')->setParameter('membre', $id_user)
           // ->andWhere('a.type= :Animal perdu')->setParameter('type','animal perdu')
            ->andWhere('a.dateAnnonce < :today')->setParameter('today', new \DateTime())
        ;

        $results = $qb->getQuery()->getResult();

        return $results;
    }

public function afficheAnnonceParType($type)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                select a from AnnonceBundle:Annonce a WHERE a.type=:type
            ") ->setParameter('type',$type)
        ;
        return $query->getResult();
    }



}