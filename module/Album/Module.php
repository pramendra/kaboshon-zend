<?php

namespace Album;

use Zend\Db\Adapter\Adapter as Adapter;
use Album\Model\AlbumTable;

class Module {

    public function getAutoloaderConfig() {
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

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Album\Model\AlbumTable' => function($sm) {
                    $config               = $sm->get('Configuration');
                    $dbParams             = $config['db'];
                    $dbParams['username'] = $config['username_training'];
                    $dbParams['password'] = $config['password_training'];
                    $dbParams['dsn']      = $config['dsn_training'];
                    $dbAdapter            = new Adapter($dbParams);
                    $table                = new AlbumTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}