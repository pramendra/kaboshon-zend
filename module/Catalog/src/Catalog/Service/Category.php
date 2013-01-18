<?php

namespace Catalog\Service;

use Abstracts\CrudService as Service;

class Category extends Service
{

    protected function preSave()
    {
        $parent = (int) $this->entity->getParent();

        if ($parent > 0) {
            $parent = $this->em()->find($parent);
        } else
            $parent = null;

        $this->entity->setParent($parent);

        return parent::preSave();
    }

    protected function preUpdate()
    {
        if ($this->entity->getParent() == $this->entity->getid())
            $this->entity->setParent(null);
        
        return parent::preUpdate();
    }

}

