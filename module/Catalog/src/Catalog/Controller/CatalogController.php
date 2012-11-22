<?php

namespace Catalog\Controller;

use Abstracts\ActionController;
use Zend\View\Model\ViewModel;

class CatalogController extends ActionController
{    
    
    /**
     * Catalog service instance
     * 
     * @var Catalog\Service\catalog
     */
    protected $service;


    public function indexAction()
    {
                
        return false;
    }

    public function modelAction()
    {
        
    }

    public function categoryAction()
    {
        
    }
    
    public function testAction()
    {
        var_dump($this->sm()->get('ViewResolver')->resolve('catalog/catalog/index'));
        return new ViewModel(array(
           'dump' => 'ok'
        ));                                
    }
}