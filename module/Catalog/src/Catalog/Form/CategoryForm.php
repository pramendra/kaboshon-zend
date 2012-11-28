<?php

namespace Catalog\Form;

use Zend\Form\Form;

class CatalogForm extends Form
{
    public function __construct($name = 'category')
    {
        parent::__construct($name);

        $this->setAttribute('method', 'post');
    
    }
}