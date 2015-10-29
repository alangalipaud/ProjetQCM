<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Issueraffling
 */
class Issueraffling
{
    /**
     * @var boolean
     */
    private $ismarqueted;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Question
     */
    private $questionid;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Registration
     */
    private $registrationid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $answerid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answerid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set ismarqueted
     *
     * @param boolean $ismarqueted
     *
     * @return Issueraffling
     */
    public function setIsmarqueted($ismarqueted)
    {
        $this->ismarqueted = $ismarqueted;
    
        return $this;
    }

    /**
     * Get ismarqueted
     *
     * @return boolean
     */
    public function getIsmarqueted()
    {
        return $this->ismarqueted;
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
     * @return Issueraffling
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
     * Set registrationid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Registration $registrationid
     *
     * @return Issueraffling
     */
    public function setRegistrationid(\ENI\QCM\Bundle\FormateurBundle\Entity\Registration $registrationid = null)
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
     * Add answerid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Answer $answerid
     *
     * @return Issueraffling
     */
    public function addAnswerid(\ENI\QCM\Bundle\FormateurBundle\Entity\Answer $answerid)
    {
        $this->answerid[] = $answerid;
    
        return $this;
    }

    /**
     * Remove answerid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Answer $answerid
     */
    public function removeAnswerid(\ENI\QCM\Bundle\FormateurBundle\Entity\Answer $answerid)
    {
        $this->answerid->removeElement($answerid);
    }

    /**
     * Get answerid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswerid()
    {
        return $this->answerid;
    }
    
    public function __toString() {
        return "issuraffling";
    }
}
