<?php

namespace Catalog\Controller;

use Abstracts\ActionController;
use Zend\View\Model\ViewModel;

/**
 * Category Controller
 */
class CategoryController extends ActionController
{
    protected $service;

    /**
     * @return \Catalog\Service\Category
     */
    public function getService()
    {
        if (!$this->service)
            $this->service = $this->getServiceLocator()->get('category.service');

        return $this->service;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(array(
                                  'categories' => $this->getService()->fetch()
                             ));
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function editAction()
    {
        $request = $this->getRequest();
        $id      = (int)$this->getEvent()->getRouteMatch()->getParam('id');

        if (!$this->getService()->load($id))
            $this->getResponse()->setStatusCode(404);

        if ($request->isPost())
            if ($this->getService()->edit($id, $request->getPost()))
                return $this->redirect()->toRoute('admin/category/index');

        $form = $this->getService()->getForm();

        return array(
            'form' => $form
        );
    }

    /**
     * @return bool
     */
    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $this->getService()->delete($id);

        return $this->redirect()->toRoute('admin/category/index');
    }

}