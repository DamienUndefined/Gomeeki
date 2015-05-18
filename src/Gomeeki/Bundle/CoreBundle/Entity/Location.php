<?php

namespace Gomeeki\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity()
 */
class Location
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=false)
     */
    private $longitude;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="last_search", type="datetime", nullable=true)
     */
    private $lastSearch;


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
     * Set name
     *
     * @param string $name
     * @return Location
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
     * Set latitude
     *
     * @param float $latitude
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lastSearch
     *
     * @param \DateTime $lastSearch
     * @return Location
     */
    public function setLastSearch($lastSearch)
    {
        $this->lastSearch = $lastSearch;

        return $this;
    }

    /**
     * Get lastSearch
     *
     * @return \DateTime 
     */
    public function getLastSearch()
    {
        return $this->lastSearch;
    }

    /**
     * Check if a fresh tweets list already exists
     * @return bool
     */
    public function useCache($time)
    {
        $useCached = false;
        if($this->getLastSearch()) {
            if($this->getSecondsSinceLastSearch() <= $time) {
                $useCached = true;
            }
        }
        return $useCached;
    }

    /**
     * count the total of seconds between the last search and now()
     * @return int
     */
    public function getSecondsSinceLastSearch()
    {
        return time() - strtotime($this->getLastSearch()->format('Y-m-d H:i:s'));
    }

    /**
     * @param $locationName
     * @param $long
     * @param $lat
     * @return Location
     */
    public static function createLocation($locationName, $long, $lat)
    {
        $location = new Location();
        return $location->setName(strtolower($locationName))
                        ->setLongitude($long)
                        ->setLatitude($lat);
    }
}
