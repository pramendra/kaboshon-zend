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

    }

    public function modelAction()
    {

    }

    public function categoryAction()
    {

    }

    public function testAction()
    {         
        $this->getService();
        return new ViewModel(array(
           'dump' => $this->params('controller')
        ));
    }
}