<?php

namespace Catalog\Service;

use Abstracts\DomainService;

class Category extends DomainService
{

    public function addCategory($request)
    {

    }

    public function deleteCategory($id)
    {

    }

    public function editCategory($id, $params)
    {

    }

    public function listCategories($offset = 0)
    {

    }

    public function getChildCategories($id)
    {
        $category = $this->load($id);
        return $category->child;
    }

    public function getCategory($id = null)
    {
        if (!$id)
            return $this->getRepository()->findAll();
        else
            return $this->load($id);
    }
}

