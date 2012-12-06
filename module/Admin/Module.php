<?php
namespace Admin;

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
}