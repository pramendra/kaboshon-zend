<?php

namespace Abstracts;

use Abstracts\Service;
use Zend\Mvc\Exception\InvalidArgumentException;

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
    
    /**
     * FQCN for entity, wich used in this service
     * @var mixed 
     */
    protected $entityName;

    protected function em()
    {
        if (null === $this->em) {
            $this->em = $this->sm()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
  
    /**
     * Load entity by id and validate exists
     * @param type $id
     * @return \Abstracts\Entity Doctrine entity object
     */
    public function load($id)
    {
        $entity = $this->em()->find($this->entityName, (int) $id);
        
        if ($entity === null) 
            throw InvalidArgumentException($id);
        else
            return $entity;
    }        
    
    /**
     * repository for this service entity
     * 
     * @return type Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository($this->entityName);
    }
    
    /**
     * Create and return new entity
     * 
     * @return \Abstracts\Entity
     */
    public function newEntity()
    {
        return new $this->entityName;
    }
    
    /**
     * Get entity from service manager
     * 
     * @return \Abstracts\Entity
     */
    public function getEntity()
    {
        return $this->sm()->get($this->entityName);
    }    
}


