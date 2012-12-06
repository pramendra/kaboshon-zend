<?php

namespace Catalog;

use Zend\ModuleManager\ModuleManager;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return array_merge(array_merge(include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/route.config.php'), include __DIR__ . '/config/service.config.php');
    }

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch',
                              function($e) {
                $controller = $e->getTarget();
                if (get_class($controller) != 'Catalog\Controller\CatalogController')
                    $controller->layout('layout/admin');
            }, 100);
    }

}