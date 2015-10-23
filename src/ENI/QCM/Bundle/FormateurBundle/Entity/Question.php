<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Question
 */
class Question
{
    /**
     * @var string
     */
    private $wording;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \ENI\QCM\Bundle\FormateurBundle\Entity\Theme
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
     * @param \ENI\QCM\Bundle\FormateurBundle\Entity\Theme $themeid
     *
     * @return Question
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
}

