<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Test
 */
class Test
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $timepassing;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $step1;

    /**
     * @var float
     */
    private $step2;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $themeid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->themeid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Test
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
     * Set timepassing
     *
     * @param \DateTime $timepassing
     *
     * @return Test
     */
    public function setTimepassing($timepassing)
    {
        $this->timepassing = $timepassing;
    
        return $this;
    }

    /**
     * Get timepassing
     *
     * @return \DateTime
     */
    public function getTimepassing()
    {
        return $this->timepassing;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Test
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set step1
     *
     * @param float $step1
     *
     * @return Test
     */
    public function setStep1($step1)
    {
        $this->step1 = $step1;
    
        return $this;
    }

    /**
     * Get step1
     *
     * @return float
     */
    public function getStep1()
    {
        return $this->step1;
    }

    /**
     * Set step2
     *
     * @param float $step2
     *
     * @return Test
     */
    public function setStep2($step2)
    {
        $this->step2 = $step2;
    
        return $this;
    }

    /**
     * Get step2
     *
     * @return float
     */
    public function getStep2()
    {
        return $this->step2;
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
     * Add themeid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Theme $themeid
     *
     * @return Test
     */
    public function addThemeid(\ENI\QCM\Bundle\FormateurBundle\Entity\Theme $themeid)
    {
        $this->themeid[] = $themeid;
    
        return $this;
    }

    /**
     * Remove themeid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Theme $themeid
     */
    public function removeThemeid(\ENI\QCM\Bundle\FormateurBundle\Entity\Theme $themeid)
    {
        $this->themeid->removeElement($themeid);
    }

    /**
     * Get themeid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThemeid()
    {
        return $this->themeid;
    }
}

