<?php

namespace Catalog\Controller;

use Abstracts\ActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends ActionController
{
    public function indexAction()
    {
        /*return new ViewModel(array(

            ));*/
        var_dump($this->sm()->get('ViewResolver')->resolve('catalog/category/index'));
        var_dump($this->sm()->get('ViewManager')->getView());
        return true;
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