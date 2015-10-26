<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Status
     */
    private $statusid;


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
        return $this->firstname.' '.$this->lastname;
    }
}

