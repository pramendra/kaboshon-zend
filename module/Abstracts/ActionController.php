<?php

namespace Abstracts;

use Zend\Mvc\Controller\AbstractActionController;

abstract class ActionController extends AbstractActionController
{          
    /**
     * Instance of service manager. Lazy init.
     * @var Zend\ServiceManager\ServiceManager
     */
    private $serviceManager;

    /**
     * if exists ModuleName\Service\ControllerName service layer class,
     * this property is instance for them. lazy init.
     * @var \Abstracts\Service
     */
    private $priorityService;

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
     * @return Zend\ServiceManager\ServiceLocatorInterface
     */
    public function sm()
    {
        if (!$this->serviceManager)
            $this->serviceManager = $this->getServiceLocator();
        
        return $this->serviceManager;
    }                       

    /**
     * init and return priority service for this controller
     * @return \Abstracts\Service
     */
    public function getService()
    {   
        
        if (!$this->priorityServiceName) {
            $controllerName = get_called_class();        
            $this->priorityServiceName = str_replace('Controller', 'Service', 
                $this->controllerName);
        }

        if (!class_exists($this->priorityServiceName))
            throw new \RuntimeException('priority service not found: ' 
                . $this->priorityServiceName);
            
        if (!$this->priorityService)
            $this->priorityService = $this->sm($this->priorityServiceName);

        return $this->priorityService;
    }  
}