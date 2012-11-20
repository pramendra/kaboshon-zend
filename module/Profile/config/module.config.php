<?php

namespace Profile;

return array(
    'controllers' => array(
        'invokables' => array(
            'Profile\Controller\Profile' => 'Profile\Controller\ProfileController'
        )
    ),
    'router' => array(
        'routes' => array(
            'profile' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/profile[/:action][/:id]',
                    'constraints' => array(
                        'action'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'       => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller'   => 'Profile\Controller\Profile',
                        'action'       => 'index'
                    )
                )
            )
        )
    ),
    // Doctrine config
    'doctrine'   => array(
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
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'profile' => __DIR__ . '/../view'
        ),
    )
);