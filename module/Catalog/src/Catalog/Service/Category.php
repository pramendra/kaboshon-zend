<?php

namespace Catalog;

use Abstracts\DomainService as Service;
use Catalog\Entity\Category;

class Category extends Service
{
        
    public function addCategory($request)
    {
        $category = new Category;
        if 
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

