<?php

return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller'    => 'Admin\Controller\Admin',
                        'action'        => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'category' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'       => '/category[/:action][/:id]',
                            'constraints' => array(
                                'action'   => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'       => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Catalog\Controller\Category',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'product' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'       => '/product[/:action][/:id]',
                            'constraints' => array(
                                'action'   => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'       => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Catalog\Controller\Product',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);