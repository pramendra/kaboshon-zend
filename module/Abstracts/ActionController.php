<?php

namespace Abstracts;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

abstract class ActionController extends AbstractActionController
{
    /**
     * Intstance of service manage, provide access to service layer from this
     * controller. Lazy init on first call.
     * @var Zend\ServiceManager
     */
    protected $sm;

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

    protected function sm()
    {
        if (!$this->sm)
            $this->sm = $this->getServiceLocator();
        return $this->sm;
    }
}