<?php
namespace Catalog\Filter;

use Zend\InputFilter\InputFilter;

/**
 * Input filter for product entity
 */
class ProductFilter extends InputFilter
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
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

        $this->add($factory->createInput(array(
                                              'name'     => 'descr',
                                              'required' => false,
                                              'filters'  => array(
                                                  array('name' => 'StripTags'),
                                                  array('name' => 'StringTrim'),
                                              ),
                                         )));

        $this->add($factory->createInput(array(
                                              'name'       => 'price',
                                              'required'   => true,
                                              'validators' => array(
                                                  array(
                                                      'name' => 'Zend\I18n\Validator\Float'
                                                  ),
                                                  array(
                                                      'name' => 'not_empty',
                                                  ),
                                              ),
                                         )));
    }
}
