<?php

namespace Abstracts;

use Abstracts\DomainService as Service;
use Zend\Stdlib\Exception\InvalidArgumentException as InvalidArgumentException;
use Zend\Stdlib\Exception\DomainException as DomainException;
use Zend\Stdlib\Exception\LogicException as LogicException;
use Zend\Paginator\Paginator as Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;

abstract class CrudService extends Service
{

    /**
     * @var string FQCN of current inherit class
     */
    protected $caller;

    /**
     * @var mixed FQCN for entity, wich used in this service
     */
    protected $entityName;

    /**
     * @var \Abstracts\Entity Entity for this service
     */
    protected $entity;

    /**
     * @var \Zend\Form\Form form for this service entity
     */
    protected $form;

    /**
     * @var string FQCN for entity, wich used in this service
     */
    protected $formName;

    /**
     * @var string FQCN for filter, wich used in this service
     */
    protected $filterName;

    /**
     * @var \Zend\InputFilter\InputFilter filter for this service
     */
    protected $filter;

    /**
     * @var bool validation data result
     */
    protected $isValid;

    /**
     * @var int Items per page in listin items page
     */
    protected $rowsPerPage = 20;

    protected function newFilter()
    {
        return new $this->filterName;
    }

    /**
     * Create and return new form
     * @return \Zend\Form\Form
     */
    protected function newForm()
    {
        $form = new $this->formName($this->em(), $this->entity);
        if ($this->filterName)
            $form->setInputFilter($this->get('filter'));
        $form->setBindOnValidate(false);

        return $form;
    }

    /**
     * Create and return new entity
     * @param null|array $data
     * @return \Abstracts\Entity
     */
    protected function newEntity($data = null)
    {
        return new $this->entityName($data);
    }

    /**
     * Getter for service properties, this method cant work in inherit classes
     * @param string $name name of property
     * @param null|array $params
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     * @throws \Zend\Stdlib\Exception\LogicException
     * @return mixed property value like a form, filter and entity instance
     */
    public function get($name, $params = null)
    {
        if (!$name)
            return null;

        $createMethod = 'new' . ucfirst($name);

        if (!property_exists($this->caller, $name))
            throw new InvalidArgumentException("property $name not exists");

        if (!is_callable(array(get_class($this), $createMethod)))
            throw new LogicException("create method for $name property not exists");

        if (!$this->$name)
            $this->$name = $this->$createMethod();

        return $this->$name;
    }

    /**
     * Create and return new paginator object
     * @param \Doctrine\ORM\Tools\Pagination\Paginator $result Result to paginate
     * @return Paginator
     */
    public function getPaginator($result)
    {
        return new Paginator(new PaginatorAdapter($result));
    }

    /**
     * set form data form and init form object if it needed
     * @param array $data Data from different source
     * @return \Abstracts\CrudService
     */
    public function setFormData($data)
    {
        if (!$this->form)
            $this->form = $this->newForm();

        $this->form->setData($data);

        return $this;
    }

    /**
     * set entity data and init entity object if it needed
     * @param array $data Key value array include model data
     */
    public function setEntityData($data)
    {
        if (!$this->entity)
            $this->entity = $this->newEntity();

        $this->entity->populate($data);
    }

    /**
     * calling setters for entity and form objects
     */
    public function setData($data)
    {
        $this->setEntityData($data);
        $this->setFormData($data);
    }

    /**
     * Repository for this service entity
     * @return  \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->em()->getRepository($this->entityName);
    }

    /**
     * Validate data before crud operations
     * @throws \Zend\Stdlib\Exception\LogicException
     * @return bool data validation result
     */
    public function validate()
    {
        if ($this->isValid !== null)
            return $this->isValid;

        $form = $this->getForm();
        if ($form)
            return $this->isValid = $form->isValid();
        else
            throw new LogicException('form not init');
    }

    /**
     * Init on the setting service locator event
     * @throws DomainException
     */
    public function onInit()
    {
        $this->caller = get_called_class();

        if (!$this->entityName && !$this->initNameEntity())
            throw new DomainException('entity name not correct');

        if (!$this->formName && !$this->initNameForm())
            throw new DomainException('form name not correct');
    }

    /**
     * init $this->entity and $this->entityName, if service name equals to entity name
     * @param string $name "meta" name of property? which be initialized
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     * @return bool|string success init or not
     */
    protected function initName($name)
    {
        $propertyName = $name . 'Name';

        if (!property_exists($this->caller, $propertyName))
            throw new InvalidArgumentException("property $name not exists");

        if ($this->$propertyName)
            return true;

        $FQCN = str_replace('\\Service\\', '\\' . ucfirst($name) . '\\', $this->caller);
        if (class_exists($FQCN))
            return $this->$propertyName = $FQCN;
        else
            return false;
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) == 'get') {
            $property = lcfirst(substr($name, 3));

            if (property_exists($this->caller, $property))
                return $this->get($property);
            else
                throw new DomainException("method $name not exists");
        } elseif (substr($name, 0, 8) == 'initName') {
            $propertyName = lcfirst(substr($name, 8));

            if (property_exists($this->caller, $propertyName))
                return $this->initName($propertyName);
            else
                throw new DomainException("method $name not exists");
        }
    }

    /**
     * Select entity by id
     */
    public function findById($id)
    {
        return $this->em()->find($this->entityName, $id);
    }


    /**
     * Select entity by id and init another service data from entity fields
     * @param int $id
     * @return \Abstracts\Entity
     */
    public function load($id)
    {
        if ($this->entity && ($this->entity->getId() == $id))
            return $this->entity;

        $this->entity = $this->findById($id);

        if ($this->entity === null)
            return null;

        $this->setFormData($this->entity->getArrayCopy());

        return $this->entity;
    }

    //Events
    protected function preSave()
    {
        return true;
    }

    protected function preInsert()
    {
        return true;
    }

    protected function preUpdate()
    {
        return true;
    }

    protected function preDelete()
    {
        return true;
    }

    //CRUD Methods
    /**
     * Create operation
     * @param array $data new entity property values
     * @return bool result of adding
     */
    public function add($data = null)
    {
        if ($data)
            $this->setData($data);

        if (!$this->validate())
            return false;

        $em = $this->em();

        if (!$this->preSave() || !$this->preInsert())
            return false;

        $em->persist($this->entity);
        $em->flush();

        return true;
    }

    /**
     * Delete operation
     * @param int $id
     * @return bool success delete or not
     */
    public function delete($id)
    {
        if ($this->load($id) === null)
            return false;

        $em = $this->em();
        $em->remove($this->entity);

        if (!$this->preDelete())
            return false;

        $em->flush();

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
        if ($this->load($id) === null)
            return false;

        if ($data)
            $this->setData($data);
        else
            $this->setEntityData($this->getFormData());

        if (!$this->validate())
            return false;

        if (!$this->preSave() || !$this->preUpdate())
            return false;

        $this->em()->flush();

        return true;
    }

    /**
     * fetch object collections for list items
     * @param int $offset
     * @return boolean|null
     */
    public function fetch($offset = 0)
    {
        if ($offset < 0)
            return false;

        $result    = $this->getRepository()->fetch($offset, $this->rowsPerPage);
        $paginator = $this->getPaginator($result);
        if (count($result)) {
            $paginator->setCurrentPageNumber($offset);
            $paginator->setItemCountPerPage($this->rowsPerPage);

            return $paginator;
        }

        return null;
    }
}