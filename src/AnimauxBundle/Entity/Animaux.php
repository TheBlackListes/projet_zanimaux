<?php

namespace AnimauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Animaux
 *
 * @ORM\Table(name="animaux")
 * @ORM\Entity(repositoryClass="AnimauxBundle\Repository\AnimauxRepository")
 */
class Animaux
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type_animal", type="string", length=255, nullable=false)
     */
    private $type_animal;

    /**
     * @var string
     *
     * @ORM\Column(name="type_offre", type="string", length=255, nullable=false)
     */
    private $type_offre;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=255, nullable=false)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255, nullable=false)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="age", type="string", length=255, nullable=false)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="taille", type="string", length=255, nullable=false)
     */
    private $taille;

    /**
     * @var string
     *
     * @ORM\Column(name="poids", type="string", length=255, nullable=false)
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="energie", type="integer", nullable=true)
     */
    private $energie = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="forceX", type="integer", nullable=true)
     */
    private $forceX = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="sociabilite", type="integer", nullable=true)
     */
    private $sociabilite = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="intelligence", type="integer", nullable=true)
     */
    private $intelligence = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proprietaire", referencedColumnName="id", nullable=false)
     * })
     */
    private $proprietaire;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getTypeAnimal()
    {
        return $this->type_animal;
    }

    /**
     * @param string $type_animal
     */
    public function setTypeAnimal($type_animal)
    {
        $this->type_animal = $type_animal;
    }

    /**
     * @return string
     */
    public function getTypeOffre()
    {
        return $this->type_offre;
    }

    /**
     * @param string $type_offre
     */
    public function setTypeOffre($type_offre)
    {
        $this->type_offre = $type_offre;
    }

    /**
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param string $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param string $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param string $taille
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
    }

    /**
     * @return string
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * @param string $poids
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
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
     * @return int
     */
    public function getEnergie()
    {
        return $this->energie;
    }

    /**
     * @param int $energie
     */
    public function setEnergie($energie)
    {
        $this->energie = $energie;
    }

    /**
     * @return int
     */
    public function getForceX()
    {
        return $this->forceX;
    }

    /**
     * @param int $forceX
     */
    public function setForceX($forceX)
    {
        $this->forceX = $forceX;
    }

    /**
     * @return int
     */
    public function getSociabilite()
    {
        return $this->sociabilite;
    }

    /**
     * @param int $sociabilite
     */
    public function setSociabilite($sociabilite)
    {
        $this->sociabilite = $sociabilite;
    }

    /**
     * @return int
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * @param int $intelligence
     */
    public function setIntelligence($intelligence)
    {
        $this->intelligence = $intelligence;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * @param mixed $proprietaire
     */
    public function setProprietaire($proprietaire)
    {
        $this->proprietaire = $proprietaire;
    }


}

