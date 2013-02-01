<?php

namespace Catalog;

return array(
    'service_manager'=>array(
        'factories' => array(
            'category.service' => function() {
                return new Service\CategoryService();
            },
            'product.service'=> function() {
                return new Service\ProductService();
            },
        ),
    ),
);