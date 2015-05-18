<?php

namespace Gomeeki\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="history")
 * @ORM\Entity(repositoryClass="Gomeeki\Bundle\CoreBundle\Entity\Repository\HistoryRepository")
 */
class History
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=255, nullable=false)
     */
    private $sessionId;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Gomeeki\Bundle\CoreBundle\Entity\Location", cascade={"persist", "remove"})
     */
    protected $location;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_insert", type="datetime", nullable=false)
     */
    private $dateInsert;

    public function __construct($sessionId, $location)
    {
        $this->sessionId = $sessionId;
        $this->location = $location;
        $this->dateInsert = new \Datetime();
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
     * Set sessionId
     *
     * @param string $sessionId
     * @return History
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string 
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set dateInsert
     *
     * @param \DateTime $dateInsert
     * @return History
     */
    public function setDateInsert($dateInsert)
    {
        $this->dateInsert = $dateInsert;

        return $this;
    }

    /**
     * Get dateInsert
     *
     * @return \DateTime 
     */
    public function getDateInsert()
    {
        return $this->dateInsert;
    }

    /**
     * Set location
     *
     * @param \Gomeeki\Bundle\CoreBundle\Entity\Location $location
     * @return History
     */
    public function setLocation(\Gomeeki\Bundle\CoreBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Gomeeki\Bundle\CoreBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
}
