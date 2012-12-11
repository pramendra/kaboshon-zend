<?php

namespace Abstracts;

use Abstracts\Service;

/**
 * This service provide access to doctrine orm and domain models
 */
abstract class DomainService extends Service
{
    /**
     * Instance of doctrine entity manager. Lazy init on first call.
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    protected function em()
    {
        if (null === $this->em) {
            $this->em = $this->sm()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }    
}


