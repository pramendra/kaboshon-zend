<?php

namespace Abstracts;

use Zend\Mvc\Controller\AbstractActionController;

abstract class ActionController extends AbstractActionController
{          
    /**
     * Instance of service manager. Lazy init.
     * @var \Zend\ServiceManager\ServiceManager
     */
    private $serviceManager;

    /**
     * name of priority svice for this controller
     * @var string
     */
    private $priorityServiceName;

    /**
     * name of this controller, example, like Module\Controller\Index
     * @var string
     */
    protected $controllerName;
    
    /**
     * init and return service manager for this controller
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function sm()
    {
        if (!$this->serviceManager)
            $this->serviceManager = $this->getServiceLocator();
        
        return $this->serviceManager;
    }                       
}