<?php

return array(
    'modules' => array(
        'Abstracts',
        'Admin',
        'Album',
        'Application',
        'Cart',
        'Catalog',
        'Checkout',
        'Profile',
        'DoctrineModule',
        'DoctrineORMModule',
        'ZendDeveloperTools',
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
