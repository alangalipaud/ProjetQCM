<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

/**
 * Answergiven
 */
class Answergiven
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling
     */
    private $issuerafflingid;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Answer
     */
    private $answerid;


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
     * Set issuerafflingid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling $issuerafflingid
     *
     * @return Answergiven
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

    /**
     * Set answerid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Answer $answerid
     *
     * @return Answergiven
     */
    public function setAnswerid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Answer $answerid = null)
    {
        $this->answerid = $answerid;

        return $this;
    }

    /**
     * Get answerid
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\Answer
     */
    public function getAnswerid()
    {
        return $this->answerid;
    }
}
