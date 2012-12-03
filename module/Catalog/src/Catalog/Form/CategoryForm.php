<?php

namespace Catalog\Form;

use Zend\Form\Form;

class CatalogForm extends Form
{
    public function __construct($name = 'category')
    {
        parent::__construct($name);

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),           
        ));

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => '%NAME_TITLE%',
            ),
        ));

        $this->add(array(
            'name' => 'descr',
            'attributes' => array(
                'type'  => 'textarea',
            ),
            'options' => array(
                'label' => '%DESCRIPTION%',
            ),
        ));

    
    }
}