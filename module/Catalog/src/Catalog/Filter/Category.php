<?php

namespace Catalog\Filter;

use Zend\InputFilter\InputFilter;

class Category extends InputFilter
{

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $factory = $this->getFactory();

        $this->add($factory->createInput(array(
                                              'name'     => 'id',
                                              'required' => false,
                                              'filters'  => array(
                                                  array('name' => 'Int'),
                                              ),
                                         )));

        $this->add($factory->createInput(array(
                                              'name'       => 'name',
                                              'required'   => true,
                                              'filters'    => array(
                                                  array('name' => 'StripTags'),
                                                  array('name' => 'StringTrim'),
                                              ),
                                              'validators' => array(
                                                  array(
                                                      'name'    => 'StringLength',
                                                      'options' => array(
                                                          'encoding' => 'UTF-8',
                                                          'min'      => 4,
                                                          'max'      => 100,
                                                      ),
                                                  ),
                                              ),
                                         )));
        $filter = $factory->createInput(array('name' => 'parent'));
        $filter->setAllowEmpty(true)->setRequired(false);
        $this->add($filter);
    }

}