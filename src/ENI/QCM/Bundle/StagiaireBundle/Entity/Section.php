<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

/**
 * Section
 */
class Section
{
    /**
     * @var integer
     */
    private $numberofquestionsasked;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Theme
     */
    private $themeid;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Test
     */
    private $testid;


    /**
     * Set numberofquestionsasked
     *
     * @param integer $numberofquestionsasked
     *
     * @return Section
     */
    public function setNumberofquestionsasked($numberofquestionsasked)
    {
        $this->numberofquestionsasked = $numberofquestionsasked;

        return $this;
    }

    /**
     * Get numberofquestionsasked
     *
     * @return integer
     */
    public function getNumberofquestionsasked()
    {
        return $this->numberofquestionsasked;
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
     * Set themeid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Theme $themeid
     *
     * @return Section
     */
    public function setThemeid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Theme $themeid = null)
    {
        $this->themeid = $themeid;

        return $this;
    }

    /**
     * Get themeid
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\Theme
     */
    public function getThemeid()
    {
        return $this->themeid;
    }

    /**
     * Set testid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Test $testid
     *
     * @return Section
     */
    public function setTestid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Test $testid = null)
    {
        $this->testid = $testid;

        return $this;
    }

    /**
     * Get testid
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\Test
     */
    public function getTestid()
    {
        return $this->testid;
    }
}

