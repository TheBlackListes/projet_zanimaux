<?php

namespace AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="AnnonceBundle\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idannonce", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;


    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;
    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=255, nullable=true)
     */
    private $service;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_perdu", type="date", nullable=true)
     */
    private $datePerdu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_annonce", type="date", nullable=true)
     */
    private $dateAnnonce;


    /**
     * @var string
     *
     * @ORM\Column(name="periode", type="string", length=255, nullable=true)
     */
    private $periode;
    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $membre;
    /**
     * @ORM\Column(name="image", type="string" , nullable=true)
     */
    private $image;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return \DateTime
     */
    public function getDateAnnonce()
    {
        return $this->dateAnnonce;
    }

    /**
     * @param \DateTime $dateAnnonce
     */
    public function setDateAnnonce($dateAnnonce)
    {
        $this->dateAnnonce = $dateAnnonce;
    }

    /**
     * @return string
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * @param string $periode
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return \DateTime
     */
    public function getDatePerdu()
    {
        return $this->datePerdu;
    }

    /**
     * @param \DateTime $datePerdu
     */
    public function setDatePerdu($datePerdu)
    {
        $this->datePerdu = $datePerdu;
    }






    /**
     * Set membre
     *
     * @param \AppBundle\Entity\User $membre
     *
     * @return Annonce
     */
    public function setMembre(\AppBundle\Entity\User $membre = null)
    {
        $this->membre = $membre;

        return $this;
    }

    /**
     * Get membre
     *
     * @return \AppBundle\Entity\User
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


}
