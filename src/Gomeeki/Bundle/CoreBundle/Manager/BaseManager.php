<?php

namespace Gomeeki\Bundle\CoreBundle\Manager;

abstract class BaseManager
{
    protected function persistAndFlush($entity)
    {
        try {
            $this->em->persist($entity);
            $this->em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            // Here we should add logging and error handling
        }
    }
}