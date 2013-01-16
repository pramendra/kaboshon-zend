<?php

namespace Catalog\Service;

use Abstracts\CrudService as Service;

class Category extends Service
{
    //CRUD Methods
    /**
     * Create operation
     * @param array $data new entity property values
     * @return type Description
     */
    public function add($data = null)
    {
        if ($data) {
            $this->setEntityData($data);
            $this->setFormData($data);
        }

        $entity = $this->getEntity();

        if (!$this->validate())
            return false;

        $em = $this->em();

        $em->persist($entity);
        $em->flush();
        return true;
    }

    /**
     * Delete operation
     * @param type $id
     * @return bool success delete or not
     */
    public function delete($id)
    {
        $entity = $this->load($id);

        if ($entity === null)
            return false;

        $em = $this->em();
        $em->remove($entity);
        $em->flush();

        $this->entity = $entity;

        return true;
    }

    /**
     * Update operation
     * @param int $id
     * @param array $data
     * @return boolean success update or not
     */
    public function edit($id, $data = null)
    {
        if ($this->entity && ($this->entity->getId() == $id))
            $entity = $this->entity;
        else {
            $entity = $this->load($id);
            if ($entity === null)
                return false;
        }

        if ($data)
            $this->setFormData($data);
        else
            $this->setFormData($entity->populate());

        if (!$this->validate())
            return false;

        $entity->populate($this->getForm()->getData());
        $this->em()->flush();

        $this->entity = $entity;

        return true;
    }

    public function fetch($offset = 0)
    {
        if ($offset < 0)
            return false;

        $rowsPerPage = $this->rowsPerPage;

        $result          = $this->getRepository()->fetch($offset, $rowsPerPage);
        $this->paginator = new Paginator(new PaginatorAdapter($result));

        $this->paginator->setCurrentPageNumber($offset);
        $this->paginator->setItemCountPerPage($rowsPerPage);

        return $result;
    }

}

