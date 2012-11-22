<?php

namespace Catalog;

use Abstracts\DomainService as Service;

class Category extends Service
{
        
    public function addCategory($params)
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
}

