<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Registration
 */
class Registration
{
    /**
     * @var \DateTime
     */
    private $startdate;

    /**
     * @var \DateTime
     */
    private $enddate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\User
     */
    private $userid;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Test
     */
    private $testid;


    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return Registration
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    
        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return Registration
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    
        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
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
     * Set userid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\User $userid
     *
     * @return Registration
     */
    public function setUserid(\ENI\QCM\Bundle\FormateurBundle\Entity\User $userid = null)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return \ENI\QCM\Bundle\FormateurBundle\Entity\User
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set testid
     *
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Test $testid
     *
     * @return Registration
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
}

