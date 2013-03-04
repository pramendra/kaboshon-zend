<?php

namespace Catalog\Form;

use Zend\Form\Form;
use Zend\Form\FormInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Catalog\Entity\Product as Entity;

/**
 * Product Form
 */
class ProductForm extends Form
{
    public function __construct($em, $entity = null, $name = 'product')
    {
        parent::__construct($name);
        $this->em = $em;

        $this->setAttribute('method', 'post');

        /*
         * @todo Добавить гидратор для Abstracts\Entities или избавится от них
         */
        $this->setAttribute('method', 'post')
            ->setHydrator(new DoctrineObject($this->em, 'Catalog\Entity\Category', false))
            ->setObject(new Entity);

        $this->initElements();

        $this->initValues($entity);
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
                        'options' => array(
                            'label' => 'Name'
                        ),
                        'attributes' => array(
                            'type'     => 'text',
                            'required' => 'required',
                        ),
                        'options'    => array(
                            'label' => 'Name',
                        ),
                   ));

        $this->add(array(
                        'name'       => 'descr',
                        'type'       => 'Zend\Form\Element\TextArea',
                        'options'    => array(
                            'label' => 'Description,'
                        ),
                        'attributes' => array(
                            'type' => 'textarea',
                        ),
                   ));

        $this->add(array(
                        'name'       => 'price',
                        'type'       => 'Zend\Form\Element\Text',
                        'options'    => array(
                            'label' => 'Price',
                        ),
                        'attributes' => array(
                            'type'     => 'text',
                            'required' => 'required',
                            'pattern'  => '\d+(\.\d{2})?'
                        ),
                   ));

        $this->add(array(
                        'name'       => 'category',
                        'type'       => 'DoctrineORMModule\Form\Element\EntitySelect',
                        'options'    => array(
                            'label'          => 'Category',
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
                            'value' => 'Reset',
                            'id'    => 'reset-button',
                            'class' => 'btn',
                        ),
                   ));
        $this->add(array(
                        'name'       => 'goBack',
                        'type'       => 'Zend\Form\Element\Button',
                        'attributes' => array(
                            'type'  => 'button',
                            'value' => 'Back',
                            'id'    => 'go-back-button',
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
                                    'name'   => 'find',
                                    'params' => array($entity->getMainPhoto()),
                                )
                            )
                       ));
        }
    }
}