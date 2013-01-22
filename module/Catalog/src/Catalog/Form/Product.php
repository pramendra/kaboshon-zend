<?php

namespace Catalog\Form;

use Zend\Form\Form;
use Zend\Form\FormInterface;

class Product extends Form
{
    public function __construct($em, $entity = null, $name = 'product')
    {
        $this->setAttribute('method', 'post');

        $this->initElements($em);

        $this->initValues($entity);
    }

    private function initElements($em)
    {

    }

    private function initValues($em)
    {

    }
}