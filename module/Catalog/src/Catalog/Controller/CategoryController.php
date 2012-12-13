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
        return new ViewModel(array(
            'categories' => $this->getService()->getCategory()
        ));
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost())
            $this->getService()->setParams($request->getPost());

        if ($this->getService()->add())
            return $this->redirect()->toRoute('admin/category/index');
        else
            return array(
                'form' => $this->getService()->getForm()
            );
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}