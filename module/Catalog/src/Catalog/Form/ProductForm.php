<?php

namespace Catalog\Form;

use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Product Form
 */
class ProductForm extends Form
{
    public function __construct($em, $category = null, $name = 'product')
    {
        parent::__construct($name);
        $this->em = $em;

        $this->setAttribute('method', 'post');

        $this->initElements();

        $this->initValues($category, $em);
    }

    /**
     * Init Form elements
     */
    private function initElements()
    {
        $this->add(array(
                        'name' => 'id',
                        'type' => 'Zend\Form\Element\Hidden',
                   ));

        $this->add(array(
                        'name'       => 'name',
                        'type'       => 'Zend\Form\Element\Text',
                        'attributes' => array(
                            'type'     => 'text',
                            'required' => 'required',
                        ),
                        'options'    => array(
                            'label' => 'name',
                        ),
                   ));

        $this->add(array(
                        'name'       => 'descr',
                        'type'       => 'Zend\Form\Element\TextArea',
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

        $this->add(array(
                        'name'       => 'category',
                        'type'       => 'DoctrineORMModule\Form\Element\EntitySelect',
                        'options'    => array(
                            'label'          => 'category',
                            'object_manager' => $this->em,
                            'target_class'   => 'Catalog\Entity\Category',
                            'identifier'     => 'id',
                            'property'       => 'name',
                        ),
                        'attributes' => array(
                            'required' => true
                        )
                   ));

        $this->add(array(
                        'name'       => 'submit',
                        'type'       => 'Zend\Form\Element\Submit',
                        'attributes' => array(
                            'type'  => 'submit',
                            'value' => 'Go',
                            'id'    => 'submit-button',
                            'class' => 'btn btn-primary',
                        ),
                   ));

        $this->add(array(
                        'name'       => 'reset',
                        'type'       => 'Zend\Form\Element\Button',
                        'attributes' => array(
                            'type'  => 'reset',
                            'value' => 'Go',
                            'id'    => 'reset-button',
                            'class' => 'btn',
                        ),
                   ));
    }

    private function initValues($entity)
    {
        if ($entity) {
            $this->add(array(
                            'name'    => 'main_photo',
                            'type'    => 'DoctrineORMModule\Form\Element\EntitySelect',
                            'options' => array(
                                'label'          => 'main_photo',
                                'object_manager' => $this->em,
                                'target_class'   => 'Catalog\Entity\ProductPhoto',
                                'identifier'     => 'id',
                                'property'       => 'name',
                                'find_method'    => array(
                                    'name'   => 'findWithoutId',
                                    'params' => array('id' => $entity),
                                )
                            )
                       ));
        }
    }
}