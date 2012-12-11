<?php

namespace Catalog\Controller;

use Abstracts\ActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends ActionController
{

    protected $service;

    public function getService()
    {
        if (!$this->service)
            $this->service = $this->getServiceLocator()->get('category.service');

        return $this->service;
    }


    public function indexAction()
    {
//        var_dump($this->sm()->get('ViewResolver')->resolve('catalog/category/index'));
        return new ViewModel(array(
            'categories' => $this->getService()->getCategory()
        ));
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}