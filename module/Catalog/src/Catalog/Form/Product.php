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
        $this->add(array(
                        'name'       => 'id',
                        'attributes' => array(
                            'type' => 'hidden',
                        ),
                   ));

        $this->add(array(
                        'name'       => 'name',
                        'attributes' => array(
                            'type'     => 'text',
                            'required' => 'required',
                        ),
                        'options'    => array(
                            'label' => 'name',
                        ),
                   ));

        $this->add(array(
                      'name' => 'descr',
                      'attributes' => array(
                          'type' => 'textarea',
                      )
                   ));

        $this->add(array(
                        'name'       => 'price',
                        'attributes' => array(
                            'type'     => 'text',
                            'required' => 'required',
                            'pattern'  => '\d+(\.\d{2})?'
                        ),
                        'label'      => 'price'
                   ));
    }

    private function initValues($em)
    {

    }
}