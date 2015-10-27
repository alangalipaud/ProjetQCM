<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Theme
 */
class Theme
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $testid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->testid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Theme
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Add testid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Test $testid
     *
     * @return Theme
     */
    public function addTestid(\ENI\QCM\Bundle\FormateurBundle\Entity\Test $testid)
    {
        $this->testid[] = $testid;
    
        return $this;
    }

    /**
     * Remove testid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Test $testid
     */
    public function removeTestid(\ENI\QCM\Bundle\FormateurBundle\Entity\Test $testid)
    {
        $this->testid->removeElement($testid);
    }

    /**
     * Get testid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTestid()
    {
        return $this->testid;
    }
    
    public function __toString() {
        return $this->name;
    }
}
