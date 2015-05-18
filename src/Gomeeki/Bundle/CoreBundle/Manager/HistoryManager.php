<?php

namespace Gomeeki\Bundle\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;
use Gomeeki\Bundle\CoreBundle\Manager\BaseManager;
use Gomeeki\Bundle\CoreBundle\Entity\History;

class HistoryManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function findOneBy($criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    public function findBy($criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    public function saveHistory(History $history)
    {
        // if the current history doesn't exists
        if(!$this->findOneBy(array('location' => $history->getLocation(), 'sessionId' => $history->getSessionId()))) {
            $this->persistAndFlush($history);
        }
    }

    public function getRepository()
    {
        return $this->em->getRepository('GomeekiCoreBundle:History');
    }
}