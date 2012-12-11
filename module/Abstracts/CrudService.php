<?php

namespace Abstracts;

use Abstracts\DomainService as Service;
use Zend\Form\Form as From;
use Zend\Stdlib\Exception\InvalidArgumentException as InvalidArgumentException;
use Zend\Stdlib\Exception\DomainException as DomainException;
use Zend\Stdlib\Exception\LogicException as LogicException;

class CrudService extends Service
{

    /**
     * FQCN for entity, wich used in this service
     * @var mixed
     */
    protected $entityName;

    /**
     * Entity for this service
     * @var \Abstracts\Entity 
     */
    protected $entity;

    /**
     * Form for this service entity
     * @var \Zend\From\From  
     */
    protected $form;

    /**
     * FQCN for entity, wich used in this service
     * @var \Zend\From\From  
     */
    protected $formName;

    /**
     * Setter for $this->form
     * @param \Zend\Form\Form $form
     */
    public function setForm(From $form)
    {
        $this->from = $form;
    }

    /**
     * Getter for $this->form
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Create and return new form
     * @return \Zend\Form\Form
     */
    public function newForm()
    {
        return new $this->form;
    }

    /**
     * Load entity by id and validate exists
     * @param type $id
     * @return \Abstracts\Entity Doctrine entity object
     */
    public function load($id)
    {
        $entity = $this->em()->find($this->entityName, (int) $id);

        if ($entity === null)
            $this->sm()->get('response')->setStatusCode(404);
        else
            return $entity;
    }

    /**
     * repository for this service entity
     *
     * @return type Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->em()->getRepository($this->entityName);
    }

    /**
     * Create and return new entity
     *
     * @return \Abstracts\Entity
     */
    protected function newEntity()
    {
        return new $this->entityName;
    }

    /**
     * Get entity from service manager
     *
     * @return \Abstracts\Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * return entity name for this service
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * set entity name for this service
     * @param string $name
     */
    public function setEntityName($name)
    {
        $this->entityName = $name;
        return $this;
    }

    public function validate()
    {
        
    }

    /**
     * init service for CRUD operations
     */
    private function init()
    {
        if ($this->entityName && !$this->entity)
            $this->entity = $this->newEntity();
        elseif (!$this->initEntity())
            throw new InvalidArgumentException('entity name not correct');

        if ($this->formName && !$this->form)
            $this->entity = $this->newEntity();
        elseif (!$this->initEntity())
            throw new InvalidArgumentException('entity name not correct');
    }

    /**
     * init $this->entity and $this->entityName, if service name equals to entity name
     * @return bool succsess init or not
     */
    private function initEntity()
    {

        if ($this->entity)
            return true;

        $entityName = str_replace('\\Service\\', '\\Entity\\', get_class($this));

        if (class_exists($entityName)) {
            $this->entityName = $entityName;
            $this->entity     = $this->newEntity();
            return true;
        } else
            return false;
    }

    /**
     * init $this->form and $this->formName, if service name equals to form name concat "Form"
     * @return bool succsess init or not
     */
    private function initForm()
    {

        if ($this->form)
            return true;

        $formName = str_replace('\\Service\\', '\\From\\', get_class($this)) . 'Form';

        if (class_exists($formName)) {
            $this->entityName = $formName;
            $this->entity     = $this->newEntity();
            return true;
        } else
            return false;
    }

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->init();
    }

}