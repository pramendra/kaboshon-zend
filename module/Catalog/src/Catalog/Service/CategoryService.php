<?php

namespace Catalog\Service;

use Abstracts\CrudService as Service;
use Zend\Http\Request;

/**
 * Category manage service
 */
class CategoryService extends Service
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
    public function add(Request $request)
    {
        $em = $this->em();
        $form = $this->getForm();
        if ($request->isPost()) {
            $category = $this->getEntity();
            $form->bind($category)->setData($request->getPost());

            if ($form->isValid()) {
                //Определение категории - родителя
                $parent = (int) $category->getParent();
                if ($parent > 0)
                    $parent = $this->findById($parent);
                else
                    $parent = null;
                $category->setParent($parent);

                //Сохранение категории
                $em->persist($category);
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
     * @return bool|\Zend\Form\Form
     */
    public function edit($id, $request)
    {
        $category = $this->load($id);
        $form = $this->getForm($category);
        if ($category === null)
            return $form;

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->em()->flush();
                return true;
            }
        }

        return $form;
    }

    /**
     * Delete category
     * @param int $id
     */
    public function delete($id)
    {
        $category = $this->load($id);
        if ($category === null)
            return;
        $em = $this->em();
        $em->remove($category);
        $em->flush();
    }

}

