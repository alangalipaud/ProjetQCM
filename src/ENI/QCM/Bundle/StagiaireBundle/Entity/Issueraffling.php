<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Issueraffling
 *
 * @ORM\Table(name="issueraffling", indexes={@ORM\Index(name="fk_issueRaffling_question", columns={"questionId"}), @ORM\Index(name="fk_issueRaffling_registration", columns={"registrationId"})})
 * @ORM\Entity
 */
class Issueraffling
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="isMarqueted", type="boolean", nullable=false)
     */
    private $ismarqueted;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Question
     *
     * @ORM\ManyToOne(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="questionId", referencedColumnName="id")
     * })
     */
    private $questionid;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Registration
     *
     * @ORM\ManyToOne(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Registration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registrationId", referencedColumnName="id")
     * })
     */
    private $registrationid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Answer", inversedBy="issuerafflingid")
     * @ORM\JoinTable(name="answergiven",
     *   joinColumns={
     *     @ORM\JoinColumn(name="issueRafflingId", referencedColumnName="questionId")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="answerId", referencedColumnName="id")
     *   }
     * )
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
     * Set questionId
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Question $questionId
     *
     * @return Issueraffling
     */
    public function setQuestionId(\ENI\QCM\Bundle\StagiaireBundle\Entity\Question $questionId = null)
    {
        $this->questionid = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\Question
     */
    public function getQuestionId()
    {
        return $this->questionid;
    }

    /**
     * Set registrationid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Registration $registrationid
     *
     * @return Issueraffling
     */
    public function setRegistrationid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Registration $registrationid = null)
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
     * Add answerid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Answer $answerid
     *
     * @return Issueraffling
     */
    public function addAnswerid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Answer $answerid)
    {
        $this->answerid[] = $answerid;

        return $this;
    }

    /**
     * Remove answerid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Answer $answerid
     */
    public function removeAnswerid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Answer $answerid)
    {
        $this->answerid->removeElement($answerid);
    }
    
    public function removeAllAnswer()
    {
        $this->answerid->clear();
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
        return $this->id.' - '.$this->questionid->getWording();
    }
}
