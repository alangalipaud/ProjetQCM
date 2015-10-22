<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="fk_question_theme", columns={"themeId"})})
 * @ORM\Entity
 */
class Question
{
    /**
     * @var string
     *
     * @ORM\Column(name="wording", type="string", length=2048, nullable=false)
     */
    private $wording;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\StagiaireBundle\Entity\Theme
     *
     * @ORM\ManyToOne(targetEntity="ENI\QCM\Bundle\StagiaireBundle\Entity\Theme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="themeId", referencedColumnName="id")
     * })
     */
    private $themeid;



    /**
     * Set wording
     *
     * @param string $wording
     *
     * @return Question
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
     * @return Question
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
}
