<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File;


/**
 * Produit
 *
 * @ORM\Table(name="produit")
 *  @ORM\Entity(repositoryClass="ProduitBundle\Repository\ProduitRepository")
 */

class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_membre", referencedColumnName="id", nullable=false)
     * })
     */
    private $id_membre;



    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
 */
    private $libelle;



    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;


    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false)
     */
    private $etat;


    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255, nullable=true)
     */
    private $marque;

    /**
     * @var integer
     *
     * @ORM\Column(name="visibilite", type="integer")
     */
    private $visibilite;

    /**
     * return int
    */
        public function getVisibilite()
    {
        return $this->visibilite;
    }

    /**
    * @param int $visib
    */
    public function setVisibilite($visibilite)
    {
        $this->visibilite = $visibilite;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $idproduit
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
 * @return string
 */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }



    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param string $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    /**
     * @return mixed
     */
    public function getIdMembre()
    {
        return $this->id_membre;
    }

    /**
     * @param mixed $id_membre
     */
    public function setIdMembre($id_membre)
    {
        $this->id_membre = $id_membre;
    }


    /**
     * @return mixed
     * @ORM\Column(type="string")
     */

    protected  $pathImage;


    /**
     * @return mixed
     */
    public function getPathImage()
    {
        return $this->pathImage;
    }

    /**
     * @param mixed $pathImage
     */
    public function setPathImage($pathImage)
    {
        $this->pathImage = $pathImage;
    }

    private $image;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(UploadedFile $image)
    {
        $this->image = $image;
        return $this;
    }

    public function getUploadDir()
    {
        return 'images';
    }

    public function getAbsolutePath()
    {
        return $this->getAbsoluteRoot().'/'.$this->image->getClientOriginalName();
    }

    public function getAbsoluteRoot()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir().'/';
    }

    public function upload()
    {

        if($this->image==null)
        {
            return;
        }
        $this->pathImage = $this->image->getClientOriginalName();
        if(!is_dir($this->getAbsoluteRoot()))
        {
            mkdir($this->getAbsoluteRoot(),'0777',true);
        }
        $this->image->move($this->getAbsoluteRoot(),$this->pathImage);
        unset($this->image);

    }


}

