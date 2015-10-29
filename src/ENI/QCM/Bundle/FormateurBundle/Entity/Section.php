<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

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
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Theme
     */
    private $themeid;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Test
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
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Theme $themeid
     *
     * @return Section
     */
    public function setThemeid(\ENI\QCM\Bundle\FormateurBundle\Entity\Theme $themeid = null)
    {
        $this->themeid = $themeid;

        return $this;
    }

    /**
     * Get themeid
     *
     * @return \ENI\QCM\Bundle\FormateurBundle\Entity\Theme
     */
    public function getThemeid()
    {
        return $this->themeid;
    }

    /**
     * Set testid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Test $testid
     *
     * @return Section
     */
    public function setTestid(\ENI\QCM\Bundle\FormateurBundle\Entity\Test $testid = null)
    {
        $this->testid = $testid;

        return $this;
    }

    /**
     * Get testid
     *
     * @return \ENI\QCM\Bundle\FormateurBundle\Entity\Test
     */
    public function getTestid()
    {
        return $this->testid;
    }
    
    public function __toString() {
        return (string)$this->numberofquestionsasked;
    }
}

