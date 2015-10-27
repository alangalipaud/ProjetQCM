<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer", indexes={@ORM\Index(name="fk_answer_question", columns={"questionId"})})
 * @ORM\Entity
 */
class Answer
{
    /**
     * @var string
     *
     * @ORM\Column(name="wording", type="string", length=250, nullable=false)
     */
    private $wording;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isValid", type="boolean", nullable=false)
     */
    private $isvalid;

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
    private $questionId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling", mappedBy="answerid")
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
     * Set questionId
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Question $questionId
     *
     * @return Answer
     */
    public function setQuestionid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Question $questionId = null)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\Question
     */
    public function getQuestionid()
    {
        return $this->questionId;
    }

    /**
     * Add issuerafflingid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling $issuerafflingid
     *
     * @return Answer
     */
    public function addIssuerafflingid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling $issuerafflingid)
    {
        $this->issuerafflingid[] = $issuerafflingid;

        return $this;
    }

    /**
     * Remove issuerafflingid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling $issuerafflingid
     */
    public function removeIssuerafflingid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling $issuerafflingid)
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
    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Question
     */
    private $questionid;


}
