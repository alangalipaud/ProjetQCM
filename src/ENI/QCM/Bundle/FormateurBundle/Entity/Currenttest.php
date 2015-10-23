<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Currenttest
 */
class Currenttest
{
    /**
     * @var \DateTime
     */
    private $currenttime;

    /**
     * @var boolean
     */
    private $iscompleted;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Registration
     */
    private $registrationid;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling
     */
    private $issuerafflingid;


    /**
     * Set currenttime
     *
     * @param \DateTime $currenttime
     *
     * @return Currenttest
     */
    public function setCurrenttime($currenttime)
    {
        $this->currenttime = $currenttime;
    
        return $this;
    }

    /**
     * Get currenttime
     *
     * @return \DateTime
     */
    public function getCurrenttime()
    {
        return $this->currenttime;
    }

    /**
     * Set iscompleted
     *
     * @param boolean $iscompleted
     *
     * @return Currenttest
     */
    public function setIscompleted($iscompleted)
    {
        $this->iscompleted = $iscompleted;
    
        return $this;
    }

    /**
     * Get iscompleted
     *
     * @return boolean
     */
    public function getIscompleted()
    {
        return $this->iscompleted;
    }

    /**
     * Set registrationid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Registration $registrationid
     *
     * @return Currenttest
     */
    public function setRegistrationid(\ENI\QCM\Bundle\FormateurBundle\Entity\Registration $registrationid)
    {
        $this->registrationid = $registrationid;
    
        return $this;
    }

    /**
     * Get registrationid
     *
     * @return \ENI\QCM\Bundle\FormateurBundle\Entity\Registration
     */
    public function getRegistrationid()
    {
        return $this->registrationid;
    }

    /**
     * Set issuerafflingid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling $issuerafflingid
     *
     * @return Currenttest
     */
    public function setIssuerafflingid(\ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling $issuerafflingid = null)
    {
        $this->issuerafflingid = $issuerafflingid;
    
        return $this;
    }

    /**
     * Get issuerafflingid
     *
     * @return \ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling
     */
    public function getIssuerafflingid()
    {
        return $this->issuerafflingid;
    }
}

