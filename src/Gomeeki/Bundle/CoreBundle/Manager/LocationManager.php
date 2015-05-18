<?php

namespace Gomeeki\Bundle\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;
use Gomeeki\Bundle\CoreBundle\Manager\BaseManager;
use Gomeeki\Bundle\CoreBundle\Entity\Location;

class LocationManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function findByName($locationName)
    {
        return $this->getRepository()->findOneBy(array('name' => strtolower($locationName)));
    }

    public function saveLocation(Location $location)
    {
        $this->persistAndFlush($location);
    }

    public function getRepository()
    {
        return $this->em->getRepository('GomeekiCoreBundle:Location');
    }

}