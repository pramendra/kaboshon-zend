<?php

namespace Catalog;

return array(
    'controllers' => array(
        'invokables' => array(
            'Catalog\Controller\Catalog'  => 'Catalog\Controller\CatalogController',
            'Catalog\Controller\Admin'    => 'Catalog\Controller\CatalogAdminController',
            'Catalog\Controller\Product'  => 'Catalog\Controller\ProductController',
            'Catalog\Controller\Category' => 'Catalog\Controller\CategoryController',
            'Catalog\Controller\Test'     => 'Catalog\Controller\TestController',
        ),
    ),
    // The following section is new and should be added to your file
    'router'                      => array(
        'routes' => array(
            'category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/category/:id[-:alias]',
                    'constraints' => array(
                        'id'       => '[0-9]+',
                        'alias'    => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Catalog\Controller\Catalog',
                        'action'     => 'category'
                    ),
                ),
            ),
            'model'      => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/model/:id[-:alias]',
                    'constraints' => array(
                        'id'       => '[0-9]+',
                        'alias'    => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Catalog\Controller\Catalog',
                        'action'     => 'model',
                    ),
                ),
            ),
            'test'       => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/test',
                    'defaults' => array(
                        'controller' => 'Catalog\Controller\Catalog',
                        'action'     => 'test',
                    ),
                ),
            ),
        ),
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
    'template_path_stack' => array(
        __DIR__ . '/../view',
//        'catalog' => __DIR__ . '/../view',
//        'catalog/test' => __DIR__ . '/../view/catalog/test'
    )
);