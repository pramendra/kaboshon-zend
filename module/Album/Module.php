<?php

namespace Album;

use Album\Model\AlbumTable;
use Album\Model\ProductTable;
use Album\Model\BugTable;
use Album\Model\UserTable;

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

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'Album\Model\AlbumTable'   => 'AlbumTable',
                'Album\Model\ProductTable' => 'ProductTable',
                'Album\Model\UserTable'    => 'UserTable',
                'Album\Model\BugTable'     => 'BugTable',
            ),
            'factories'=> array(
                'AlbumTable' => function($sm) {
                    return new AlbumTable($sm->get('TestDbAdapter'));
                },
                'ProductTable' => function ($sm) {
                    return new ProductTable($sm->get('TestDbAdapter'));
                },
                'UserTable' => function ($sm) {
                    return new UserTable($sm->get('TestDbAdapter'));
                },
                'BugTable' => function ($sm) {
                    return new BugTable($sm->get('TestDbAdapter'));
                },
            ),
                    
        );
    }

    public function getConfig()
    {
        return array_merge(include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/services.config.php');
    }

}