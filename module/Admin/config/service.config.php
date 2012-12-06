<?php

namespace Catalog;

return array(
    'service_manager'=>array(
        'factories' => array(
            'category.service' => function() {
                return new Service\Category(array('entityName' => 'Catalog\Entity\Category'));
            },
            'product.service'=> function() {
                return new Service\Product(array('entityName' => 'Catalog\Entity\Product'));
            },
        ),
    ),
);