<?php

namespace Catalog\Controller;

use Abstracts\ActionController;

class ProductController extends ActionController
{

    protected $service;

    public function getService()
    {
        if (!$this->service)
            $this->service = $this->getServiceLocator()->get('product.service');

        return $this->service;
    }

    public function indexAction()
    {

    }
}