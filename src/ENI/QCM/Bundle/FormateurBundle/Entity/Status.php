<?php

namespace ENI\QCM\Bundle\FormateurBundle\Entity;

/**
 * Status
 */
class Status
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
     * Set wording
     *
     * @param string $wording
     *
     * @return Status
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
    
    public function __toString() {
        return $this->wording;
    }
}

