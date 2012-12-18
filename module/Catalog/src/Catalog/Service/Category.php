<?php

namespace Catalog\Service;

use Abstracts\CrudService as Service;

class Category extends Service
{

    public function add(array $data = null)
    {
        if ($data)
            $this->setFormData($data);

    }

    public function delete($id)
    {
        
    }

    public function edit($id, $data = null)
    {
        if ($data)
            $this->setFormData($data);
    }

    public function fetch($offset = 0)
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

