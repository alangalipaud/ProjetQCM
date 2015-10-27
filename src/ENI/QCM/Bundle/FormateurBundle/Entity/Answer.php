<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Answer
 */
class Answer
{
    /**
     * @var string
     */
    private $wording;

    /**
     * @var boolean
     */
    private $isvalid;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Question
     */
    private $questionid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $issuerafflingid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->issuerafflingid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set wording
     *
     * @param string $wording
     *
     * @return Answer
     */
    public function setWording($wording)
    {
        $this->wording = $wording;
    
        return $this;
    }

    /**
     * Get wording
     *
     * @return string
     */
    public function getWording()
    {
        return $this->wording;
    }

    /**
     * Set isvalid
     *
     * @param boolean $isvalid
     *
     * @return Answer
     */
    public function setIsvalid($isvalid)
    {
        $this->isvalid = $isvalid;
    
        return $this;
    }

    /**
     * Get isvalid
     *
     * @return boolean
     */
    public function getIsvalid()
    {
        return $this->isvalid;
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
     * Set questionid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Question $questionid
     *
     * @return Answer
     */
    public function setQuestionid(\ENI\QCM\Bundle\FormateurBundle\Entity\Question $questionid = null)
    {
        $this->questionid = $questionid;
    
        return $this;
    }

    /**
     * Get questionid
     *
     * @return \ENI\QCM\Bundle\FormateurBundle\Entity\Question
     */
    public function getQuestionid()
    {
        return $this->questionid;
    }

    /**
     * Add issuerafflingid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling $issuerafflingid
     *
     * @return Answer
     */
    public function addIssuerafflingid(\ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling $issuerafflingid)
    {
        $this->issuerafflingid[] = $issuerafflingid;
    
        return $this;
    }

    /**
     * Remove issuerafflingid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling $issuerafflingid
     */
    public function removeIssuerafflingid(\ENI\QCM\Bundle\FormateurBundle\Entity\Issueraffling $issuerafflingid)
    {
        $this->issuerafflingid->removeElement($issuerafflingid);
    }

    /**
     * Get issuerafflingid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIssuerafflingid()
    {
        return $this->issuerafflingid;
    }
}
