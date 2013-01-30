<?php

namespace Catalog\Form;

use Zend\Form\Form;
use Zend\Form\FormInterface;

class Category extends Form
{

    public function __construct($em, $entity = null, $name = 'category')
    {
        parent::__construct($name);

        $this->setAttribute('method', 'post');

        $this->initElements($em);

        $this->initValues($entity);
    }

    private function initElements($em)
    {
        $this->add(array(
                        'name'       => 'id',
                        'type'       => 'Zend\Form\Element\Hidden',
                        'attributes' => array(
                            'type' => 'hidden',
                        ),
                   ));

        $this->add(array(
                        'name'       => 'name',
                        'type'       => 'Zend\Form\Element\Text',
                        'attributes' => array(
                            'type' => 'text',
                        ),
                        'options'    => array(
                            'label' => 'name',
                        ),
                   ));

        $this->add(array(
                        'name'    => 'descr',
                        'type'    => 'Zend\Form\Element\TextArea',
                        'options' => array(
                            'label' => 'description',
                        ),
                   ));

        $this->add(array(
                        'name'     => 'parent',
                        'type'     => 'DoctrineORMModule\Form\Element\DoctrineEntity',
                        'options'  => array(
                            'label'          => 'parent category',
                            'object_manager' => $em,
                            'empty_option'   => 'root category',
                            'target_class'   => 'Catalog\Entity\Category',
                            'identifier'     => 'id',
                            'property'       => 'name',
                        ),
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
                            'type'  => 'submit',
                            'value' => 'Reset',
                            'id'    => 'reset-button',
                            'class' => 'btn',
                        ),
                   ));
    }

    private function initValues($entity)
    {
        if ($entity && $entity->getId()) {
            $parent = $this->get('parent');
            $parent->setOptions(array(
                                     'find_method' => array(
                                         'name'   => 'findWithoutId',
                                         'params' => array('category' => $entity),
                                     )
                                ));
        }
    }

}