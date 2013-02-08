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
     * @return \Catalog\Service\CategoryService
     */
    public function getService()
    {
        if (!$this->service)
            $this->service = $this->getServiceLocator()->get('category.service');

        return $this->service;
    }

    /**
     * Redirect to index page
     * @return \Zend\View\Model\ViewModel
     */
    public function redirectToIndex()
    {
        return $this->redirect()->toRoute('admin/category/index');
    }


    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $offset = (int) $this->getEvent()->getRouteMatch()->getParam('id');

        return new ViewModel(array(
                                  'categories' => $this->getService()->fetch($offset)
                             ));
    }

    /**
     * @return mixed
     */
    public function addAction()
    {
        $service = $this->getService();
        $request = $this->getRequest();

        $result = $service->add($request);

        if ($result === true)
            return $this->redirectToIndex();

        return array(
            'form' => $result
        );
    }

    /**
     * @return mixed
     */
    public function editAction()
    {
        $id      = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $service = $this->getService();
        $request = $this->getRequest();

        $result = $service->edit($id, $request);

        if ($result === true)
            return $this->redirectToIndex();

        return array(
            'form' => $result
        );
    }

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $this->getService()->delete($id);

        return $this->redirectToIndex();
    }

}