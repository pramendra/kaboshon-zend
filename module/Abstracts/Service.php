<?php

namespace Abstracts;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service supertype pattern for this project service layer
 */
abstract class Service implements ServiceLocatorAwareInterface
{

    /**
     * Service options 
     * @var array  
     */
    protected $options = array();
    
    /**
     * Service Manager for this service
     * @var ServiceLocatorInterface 
     */
    protected $sm;

    /**
     * Set serviceManager instance
     *
     * @param ServiceLocatorInterface $servicelocator servicelocator     
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sm = $serviceLocator;
        return $this;
    }

    /**
     * Set serviceManager instance
     *
     * @return Service Manager     
     */
    public function getServiceLocator()
    {
        return $this->sm;
    }

    /**
     * Merge options
     *
     * @param array $options Options     
     * @return AbstractACLService
     */
    protected function mergeOptions($options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    public function __construct(array $options = array())
    {
        if (!empty($options))
            $this->options = array_merge($this->options, $options);
    }

}

