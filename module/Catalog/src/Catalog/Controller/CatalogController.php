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

    public function getService()
    {
        if (!$this->service)
            $this->service = $this->sm('Catalog/Service/Catalog');

        return $this->service;
    }

    public function indexAction()
    {

    }

    public function productAction()
    {

    }

    public function categoryAction()
    {

    }
}