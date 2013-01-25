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
                                  'categories' => $this->getService()->fetch()
                             ));
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost() && $this->getService()->add($request->getPost()))
            return $this->redirect()->toRoute('admin/category/index');

        $form = $this->getService()->getForm();

        return array(
            'form' => $form
        );
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id      = (int)$this->getEvent()->getRouteMatch()->getParam('id');

        if (!$this->getService()->load($id))
            $this->getResponse()->setStatusCode(404);

        if ($request->isPost() && $this->getService()->edit($id, $request->getPost()));
            return $this->redirect()->toRoute('admin/category/index');


        $form = $this->getService()->getForm();

        return array(
            'form' => $form
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');

        if ($this->getService()->delete($id))
            return $this->redirect()->toRoute('admin/category/index');
        else
            $this->getResponse()->setStatusCode(404);
    }

}