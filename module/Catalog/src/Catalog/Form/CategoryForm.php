<?php

namespace Catalog\Form;

use Zend\Form\Form;

class CategoryForm extends Form
{
    public function __construct($em, $name = 'category')
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

        $this->add(array(
            'name' => 'parent',
            'type' => 'DoctrineORMModule\Form\Element\DoctrineEntity',
            'options' => array(
                'label' => '%PARENT_CATEGORY%',
                'object_manager' => $em,
                'target_class'   => 'Catalog\Entity\Category',
                'identifier'     => 'id',
                'property'       => 'name'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));

        $this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type'  => 'reset',
                'value' => 'Cancel',
                'id' => 'resetbutton',
                'class' => 'btn red-btn',
            ),
        ));

    }
}