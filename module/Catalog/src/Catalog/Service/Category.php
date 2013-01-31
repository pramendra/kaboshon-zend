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
     * @return bool|\Zend\Form\Form
     */
    public function add($request)
    {
        $em = $this->em();
        $form = $this->getForm($em);
        if ($request->isPost()) {
            $category = $this->getEntity();
            $form->setData($request->getParams())->bind($category)->setData();

            if ($form->isValid()) {
                //Определение категории - родителя
                $parent = (int) $category->getParent();
                if ($parent > 0)
                    $parent = $this->findById($parent);
                else
                    $parent = null;
                $category->setParent($parent);

                //Сохранение категории
                $em->perist($category);
                $em->flush();
                return true;
            }
        }

        return $form;
    }

    /**
     * Edit category
     * @param int $id
     * @param \Zend\Http\Request
     */
    public function edit($id, $request)
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

