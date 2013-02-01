<?php

namespace Catalog\Service;

use Abstracts\CrudService as Service;

/**
 * Product service
 */
class ProductService extends Service
{
    /*protected function preSave()
    {
        $category = (int) $this->entity->getCategory();

        if ($category > 0) {
            $category = $this->em()->find('Catalog\Entity\Category' ,$category);
        } else
            $category = null;

        $this->entity->setCategory($category);
        return parent::preSave();
    }*/
}

