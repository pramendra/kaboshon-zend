<?php

namespace Catalog\Service;

use Abstracts\CrudService as Service;
use Catalog\Service\CategoryService;
use Zend\Http\Request;

/**
 * Product service
 */
class ProductService extends Service
{
    public function fetch($offset = 0)
    {
        $entities  = $this->getRepository()->getAdminPaginator($offset, $this->rowsPerPage);
        $paginator = $this->getPaginator($entities);

        return $paginator;
    }

    public function add(Request $request)
    {
        $em   = $this->em();
        $form = $this->getForm();

        if ($request->isPost()) {
            $product = $this->getEntity();
            $form->bind($product)->setData($request->getPost());

            if ($form->isValid()) {
                $category = $this->sm()->get('category.service')->findById((int) $product->getCategory());




            }
        }

        return $form;
    }
}

