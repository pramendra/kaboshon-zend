<?php

namespace Catalog\Service;

use Abstracts\CrudService as Service;

/**
 * Category manage service
 */
class Category extends Service
{
    /**
     * List categories
     * @param int $offset
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($offset = 0)
    {
        $entites = $this->getRepository()->getAdminPaginator((int) $offset);
        $paginator = $this->getPaginator($entites);

        return $paginator;
    }

    /**
     * Add category
     * @param \Zend\Http\Request
     */
    public function add($request = null)
    {
        if ($request->isPost()) {

        }


    }

    /**
     * Edit category
     * @param int $id
     * @param \Zend\Http\Request
     */
    public function edit($id, $request = null)
    {

    }

    /**
     * Delete category
     * @param int $id
     */
    public function delete($id)
    {

    }

}

