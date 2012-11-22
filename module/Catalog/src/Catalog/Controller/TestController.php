<?php

namespace Catalog\Controller;

use Abstracts\ActionController;
use Zend\View\Model\ViewModel;

class TestController extends ActionController
{
    public function indexAction()
    {           
        var_dump($this->sm()->get('ViewResolver')->resolve('catalog/test/index'));
        return new ViewModel(array(
            'dump' => 'ok'
        ));
    }        
}