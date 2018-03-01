<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 25/02/2018
 * Time: 19:06
 */

namespace AnnonceBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;


/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AnnonceBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $id_user;

     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $id_reviewer;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


    /**
     * @return User
     */
    public function getIdReviewer()
    {
        return $this->id_reviewer;
    }


    /**
     * @param mixed $id_reviewer
     */
    public function setIdReviewer($id_reviewer)
    {
        $this->id_reviewer = $id_reviewer;
    }

    /**
     * @ORM\Column(name="description", type="text")
     */

    private $description;

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
     * @return \AppBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param \AppBundle\Entity\User $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
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



}