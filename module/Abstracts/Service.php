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
     *
     * @var array
     */
    protected $options = array();

    /**
     * Service Manager for this service
     *
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
        $this->onInit();
        return $this;
    }

    /**
     * Get serviceManager instance
     *
     * @return Service Manager
     */
    public function getServiceLocator()
    {
        return $this->sm;
    }

    /**
     * Get serviceManager instance, short alias
     *
     * @return Service Manager
     */
    public function sm()
    {
        return $this->sm;
    }

    /**
     * Merge options
     *
     * @param array $options Options
     * @return \Abstract\LService
     */
    protected function mergeOptions($options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    public function __construct($options = array())
    {
        if (!empty($options))
            $this->options = array_merge($this->options, $options);

        $properties = get_object_vars($this);
        unset($properties['options']);

        foreach($properties as $key => $value) {
            if (isset($this->options[$key]) && !$value) {
                $this->$key = $this->options[$key];
            }
        }
    }

    /**
     * after service locator inject event
     * 
     * @see $this->setServiceLocator()
     * @return boolean success init or not
     */
    protected function onInit()
    {
        return true;
    }

}

