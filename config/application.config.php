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
        'Model',
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
