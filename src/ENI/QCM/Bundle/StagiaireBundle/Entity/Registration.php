<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Registration
 *
 * @ORM\Table(name="registration", indexes={@ORM\Index(name="fk_registration_user", columns={"userId"}), @ORM\Index(name="fk_registration_test", columns={"testId"})})
 * @ORM\Entity
 */
class Registration
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime", nullable=false)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime", nullable=false)
     */
    private $enddate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * })
     */
    private $userid;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Test
     *
     * @ORM\ManyToOne(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="testId", referencedColumnName="id")
     * })
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
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\User $userid
     *
     * @return Registration
     */
    public function setUserid(\ENI\QCM\Bundle\StagiaireBundle\Entity\User $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \ENI\QCM\Bundle\StagiaireBundle\Entity\User
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set testid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Test $testid
     *
     * @return Registration
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
    
    public function __toString() {/*testid et userid --> toString !!!*/ 
        $message = $this->testid.' '.$this->userid.' '.$this->startdate->format('Y-m-d H:i:s').' - '.$this->enddate->format('Y-m-d H:i:s');
        return $message;
    }
}
