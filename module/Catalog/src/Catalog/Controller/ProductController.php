<?php

namespace Catalog\Controller;

use Abstracts\ActionController;
use Zend\View\Model\ViewModel;

class ProductController extends ActionController
{

    protected $service;

    public function getService()
    {
        if (!$this->service)
            $this->service = $this->getServiceLocator()->get('product.service');

        return $this->service;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(array(
                                  'products' => $this->getService()->fetch()
                             ));
    }

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

    public function editAction()
    {
        $id      = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $service = $this->getService();
        $request = $this->getRequest();

        $result = $service->edit($id, $request);

        if ($result === true)
            return $this->redirectToIndex();

        return array(
            'form' => $result
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        $this->getService()->delete($id);

        return $this->redirectToIndex();
    }
}