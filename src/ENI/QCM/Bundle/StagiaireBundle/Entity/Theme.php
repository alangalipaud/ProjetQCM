<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity
 */
class Theme
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Test", inversedBy="themeid")
     * @ORM\JoinTable(name="section",
     *   joinColumns={
     *     @ORM\JoinColumn(name="themeId", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="testId", referencedColumnName="id")
     *   }
     * )
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
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Test $testid
     *
     * @return Theme
     */
    public function addTestid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Test $testid)
    {
        $this->testid[] = $testid;

        return $this;
    }

    /**
     * Remove testid
     *
     * @param \ENI\QCM\Bundle\StagiaireBundle\Entity\Test $testid
     */
    public function removeTestid(\ENI\QCM\Bundle\StagiaireBundle\Entity\Test $testid)
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
}
