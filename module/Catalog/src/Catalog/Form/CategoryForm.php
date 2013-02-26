<?php

namespace Catalog\Form;

use Zend\Form\Form;
use Zend\Form\FormInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Catalog\Entity\Category as Entity;

class CategoryForm extends Form
{
    protected $em;

    public function __construct($em, $entity = null, $name = 'category')
    {
        parent::__construct($name);
        $this->em = $em;
        /*
         * @todo Добавить гидратор для Abstracts\Entities или избавится от них
         */
        $this->setAttribute('method', 'post')
            ->setHydrator(new DoctrineObject($this->em, 'Catalog\Entity\Category', false))
            ->setObject(new Entity);

        $this->initElements();
        $this->initValues($entity);
    }

    private function initElements()
    {
        $this->add(array(
                        'name'       => 'id',
                        'type'       => 'Zend\Form\Element\Hidden',
                        'require'    => false,
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
                        'type'     => 'DoctrineORMModule\Form\Element\EntitySelect',
                        'options'  => array(
                            'label'          => 'parent category',
                            'object_manager' => $this->em,
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
        if ($entity) {
            $this->bind($entity);
            $parent = $this->get('parent');
            $parent->setOptions(array(
                                     'find_method' => array(
                                         'name'   => 'findWithoutId',
                                         'params' => array('category' => $entity),
                                     )
                                ));
            $parentEntity = $entity->getParent();
            if ($parentEntity)
                $parent->setValue($parentEntity->getId());
        }
    }

}