<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Currenttest
 *
 * @ORM\Table(name="currenttest", indexes={@ORM\Index(name="fk_currenttest_issueraffling", columns={"issueRafflingId"})})
 * @ORM\Entity
 */
class Currenttest
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="currentTime", type="datetime", nullable=false)
     */
    private $currenttime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isCompleted", type="boolean", nullable=false)
     */
    private $iscompleted;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Registration
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Registration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registrationId", referencedColumnName="id")
     * })
     */
    private $registrationid;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling
     *
     * @ORM\ManyToOne(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="issueRafflingId", referencedColumnName="id")
     * })
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
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Registration $registrationid
     *
     * @return Currenttest
     */
    public function setRegistrationid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Registration $registrationid)
    {
        $this->registrationid = $registrationid;

        return $this;
    }

    /**
     * Get registrationid
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\Registration
     */
    public function getRegistrationid()
    {
        return $this->registrationid;
    }

    /**
     * Set issuerafflingid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling $issuerafflingid
     *
     * @return Currenttest
     */
    public function setIssuerafflingid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling $issuerafflingid = null)
    {
        $this->issuerafflingid = $issuerafflingid;

        return $this;
    }

    /**
     * Get issuerafflingid
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling
     */
    public function getIssuerafflingid()
    {
        return $this->issuerafflingid;
    }
}
