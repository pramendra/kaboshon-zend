<?php
return array(
    'modules' => array(
        'Application',
        'Album',
        'Cart',
        'Catalog',
        'Checkout',        
        'Profile',
        'DoctrineModule',
        'DoctrineORMModule',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
