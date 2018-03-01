<?php
/**
 * Created by PhpStorm.
 * User: Tritux
 * Date: 25/02/2018
 * Time: 17:17
 */

namespace VeterinaireBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity

 * @ORM\Table(name="note_veterinaire")
 */
class NoteVeterinaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;
    /**
     * @var \VeterinaireBundle\Entity\Veterinaire
     * @ORM\ManyToOne(targetEntity="VeterinaireBundle\Entity\Veterinaire")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="idVeterinaire" ,referencedColumnName="id")})
     *
     */private $idVeterinaire;
    /**
     * @ORM\Column(type="integer")
     */private $note;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \VeterinaireBundle\Entity\Veterinaire
     */
    public function getIdVeterinaire()
    {
        return $this->idVeterinaire;
    }

    /**
     * @param \VeterinaireBundle\Entity\Veterinaire $idVeterinaire
     */
    public function setIdVeterinaire($idVeterinaire)
    {
        $this->idVeterinaire = $idVeterinaire;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }



}