<?php
/**
 * Created by PhpStorm.
 * User: houss
 * Date: 2/24/2018
 * Time: 12:01 PM
 */

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Participation
 *
 * @ORM\Table(name="participation")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\ParticipationRepository")
 */

class Participation
{ /**
 * @var integer
 *
 * @ORM\Column(name="id", type="integer", nullable=false)
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="IDENTITY")
 */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_user;

    /**
     * @var \EvenementBundle\Entity\Evenement
     *
     * @ORM\ManyToOne(targetEntity="EvenementBundle\Entity\Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_evenement", referencedColumnName="id")
     * })
     */
    private $id_evenement;

    /**
     * @return \AppBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param  \AppBundle\Entity\User $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return \EvenementBundle\Entity\Evenement
     */
    public function getIdEvenement()
    {
        return $this->id_evenement;
    }

    /**
     * @param \EvenementBundle\Entity\Evenement $id_evenement
     */
    public function setIdEvenement($id_evenement)
    {
        $this->id_evenement = $id_evenement;
    }

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


}