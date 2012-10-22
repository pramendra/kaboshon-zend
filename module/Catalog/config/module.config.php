<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Catalog\Controller\Catalog' => 'Catalog\Controller\CatalogController',
        ),
    ),

    // The following section is new and should be added to your file
    'router'                 => array(
        'routes' => array(
            'catalog' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/[:controller[/:action]]',                  
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'      => 'Catalog\Controller\Catalog',
                        'action'          => 'index',
                    ),
                ),
            ),
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
            ),                
        ),        
    ),
    'view_manager'            => array(
        'template_path_stack' => array(
            'catalog' => __DIR__ . '/../view',
        ),
    ),
);