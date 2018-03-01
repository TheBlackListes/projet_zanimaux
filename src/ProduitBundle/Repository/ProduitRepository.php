<?php

namespace ProduitBundle\Repository;
use Doctrine\ORM\EntityRepository;



class ProduitRepository extends EntityRepository
{
    public function AfficherProduitParType($type)
    {
        $query = $this->getEntityManager()
            ->createQuery(" select p 
 from ProduitBundle\Entity\Produit p 
 WHERE p.type=:type AND p.visibilite=1 
 ORDER BY p.id DESC")
            ->setParameter('type', $type);
        return $query->getResult();
    }

    public function afficherproduitUser($id_user)
    {
        $query = $this->getEntityManager()
            ->createQuery("select m from ProduitBundle\Entity\Produit m WHERE m.id_membre=:id_user")
            ->setParameter('id_user', $id_user);
        return $query->getResult();
    }

    public function NombreProduitDuUserParCategorie($id_user, $categorie)
    {
        $query = $this->getEntityManager()->createQuery("Select COUNT(p) FROM ProduitBundle\Entity\Produit p WHERE p.id_membre=:id_user AND p.categorie=:categorie")
            ->setParameter('id_user', $id_user)
            ->setParameter('categorie', $categorie);
        return $query->getSingleScalarResult();
    }


    public function NombreProduitDuUser($id_user)
    {
        $q = $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.id_membre= :id_user')
            ->setParameter('id_user', $id_user);
        $q->getQuery()->getSingleScalarResult();
    }


    public function NombreProduitParCategorie($categorie)
    {
        $query = $this->getEntityManager()->createQuery("Select COUNT(p) FROM ProduitBundle\Entity\Produit p WHERE p.categorie=:categorie")
            ->setParameter('categorie', $categorie);
        return $query->getSingleScalarResult();
    }

    public function NombreAnimauxParCategorie($categorie)
    {
        $query = $this->getEntityManager()->createQuery("Select COUNT(p) FROM AnimauxBundle\Entity\Animaux p WHERE p.type_animal=:categorie")
            ->setParameter('categorie', $categorie);
        return $query->getSingleScalarResult();
    }




    public function NbreUser ()
    {
        $query=$this->getEntityManager()->createQuery("Select COUNT(u) FROM AppBundle\Entity\User u");
        return $query->getSingleScalarResult();
    }

    public function NbreAnimaux ()
    {
        $query=$this->getEntityManager()->createQuery("Select COUNT(a) FROM AnimauxBundle\Entity\Animaux a");
        return $query->getSingleScalarResult();
    }

    public function NbreProduits ()
    {
        $query=$this->getEntityManager()->createQuery("Select COUNT(p) FROM ProduitBundle\Entity\Produit p");
        return $query->getSingleScalarResult();
    }

    public function NbreAnnonces ()
    {
        $query=$this->getEntityManager()->createQuery("Select COUNT(a) FROM AnnonceBundle\Entity\Annonce a");
        return $query->getSingleScalarResult();
    }

    public function NbreEvenements ()
    {
        $query=$this->getEntityManager()->createQuery("Select COUNT(e) FROM EvenementBundle\Entity\Evenement e");
        return $query->getSingleScalarResult();
    }


    public function Recherche($chaine, $categorie)
    {

        $query = $this->getEntityManager()->createQuery("Select p FROM ProduitBundle\Entity\Produit p WHERE p.visibilite=1 AND p.libelle=:chaine AND p.categorie=:categorie")
            ->setParameter('categorie', $categorie)
            ->setParameter('chaine', $chaine);
        return $query->getResult();

    }

    public function TriPlusCherMoinsCher()
    {

        $query = $this->getEntityManager()->createQuery("Select p FROM ProduitBundle\Entity\Produit p ORDER BY prix DESC ");
        return $query->getResult();

    }


    public function TriMoinsCherPlusCher()
    {

        $query = $this->getEntityManager()->createQuery("Select p FROM ProduitBundle\Entity\Produit p ORDER BY prix ASC ");
        return $query->getResult();

    }

    public function TriDec()
    {

        $query = $this->getEntityManager()->createQuery("Select p FROM ProduitBundle\Entity\Produit p ORDER BY id DESC ");
        return $query->getResult();

    }

    public function TriCroi()
    {

        $query = $this->getEntityManager()->createQuery("Select p FROM ProduitBundle\Entity\Produit p ORDER BY id ASC");
        return $query->getResult();


    }


}

