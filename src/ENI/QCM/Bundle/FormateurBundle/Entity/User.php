<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="`user`", indexes={@ORM\Index(name="fk_user_status", columns={"statusId"})})
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50, nullable=false)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=50, nullable=false)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=128, nullable=false)
     */
    protected $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=20, nullable=false)
     */
    protected $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="ENI\QCM\Bundle\FormateurBundle\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="statusId", referencedColumnName="id")
     * })
     */
    protected $statusid;



    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set statusid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Status $statusid
     *
     * @return User
     */
    public function setStatusid(\ENI\QCM\Bundle\FormateurBundle\Entity\Status $statusid = null)
    {
        $this->statusid = $statusid;

        return $this;
    }

    /**
     * Get statusid
     *
     * @return \ENI\QCM\Bundle\FormateurBundle\Entity\Status
     */
    public function getStatusid()
    {
        return $this->statusid;
    }
    
    public function __toString() {
        return $this->lastname.' - '.$this->firstname.' : '.$this->mail;
    }
}
