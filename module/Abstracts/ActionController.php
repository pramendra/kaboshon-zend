<?php

namespace Abstracts;

use Zend\Mvc\Controller\AbstractActionController;

abstract class ActionController extends AbstractActionController
{          
    /**
     * Instance of service manager. Lazy initializated.
     * @var Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;
    
    public function sm()
    {
        if (!$this->serviceManager)
            $this->serviceManager = $this->getServiceLocator();
        
        return $this->sm;
    }                   
}