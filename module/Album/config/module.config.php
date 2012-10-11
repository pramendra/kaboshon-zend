<?php

namespace Album;

return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
        ),
    ),
    // The following section is new and should be added to your file
    'router'                 => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'       => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller'      => 'Album\Controller\Album',
                        'action'          => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'TestDbAdapter' => function ($sm) {
                $config               = $sm->get('Configuration');
                $dbParams             = $config['db'];
                $dbParams['username'] = $config['username_training'];
                $dbParams['password'] = $config['password_training'];
                $dbParams['dsn']      = $config['dsn_training'];
                $dbAdapter            = new Zend\Db\Adapter\Adapter($dbParams);
                return $dbAdapter;
            },
        ),
    ),
    // Doctrine config
    'doctrine'            => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
                
            )
        )
    ),
    'view_manager'            => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);