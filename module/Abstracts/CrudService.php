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
     * @var \Zend\From\From form for this service entity
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
     * @var \Zend\Pagination\Paginator paginator component, init in $this->fetch()
     * @see $this->fetch()
     */
    protected $paginator;

    /**
     * @var bool validation data result
     */
    protected $isValid;
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
        $form = new $this->formName($this->em());
        $form->setInputFilter($this->get('filter'))
            ->setBindOnValidate(false);

        return $form;
    }

    /**
     * Create and return new entity
     * @return \Abstracts\Entity
     */
    protected function newEntity($data = null)
    {
        return new $this->entityName($data);
    }

    /**
     * Getter for service properties, this method cant work in inherit classes
     * @param string $name name of property
     * @return mixed property value like a form, filter and entity instance
     */
    public function get($name)
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
     * create new form instance, init sevice form and entity and set from data
     * @param array $name Data from different source
     */
    public function setFormData($data)
    {
        if (!$this->form)
            $this->form = $this->newForm();

        $this->form->setData($data);
    }

    /**
     *
     * @param array $data Key value array include model data
     */
    public function setEntityData($data)
    {
        if (!$this->entity)
            $this->entity = $this->newEntity();

        $this->entity->populate($data);
    }

    /**
     * Repository for this service entity
     * @return type Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->em()->getRepository($this->entityName);
    }

    /**
     * Validate data before crud operations
     * @return bool data validation reslut
     */
    public function validate()
    {
        if ($this->isValid !== null)
            return $this->isValid;

        $form          = $this->getForm();
        if ($form)
            return $this->isValid = $form->isValid();
        else
            throw new LogicException('form not init');
    }

    /**
     * Init on the setting service locator event
     * @throws InvalidArgumentException
     */
    public function onInit()
    {
        $this->caller = get_called_class();

        if (!$this->entityName && !$this->initNameEntity())
            throw new DomainException('entity name not correct');

        if (!$this->formName && !$this->initNameForm())
            throw new DomainException('form name not correct');

        if (!$this->filterName && !$this->initNameFilter())
            throw new DomainException('filter name not correct');
    }

    /**
     * init $this->entity and $this->entityName, if service name equals to entity name
     * @return bool succsess init or not
     */
    protected function initName($name)
    {
        $propertyName = $name . 'Name';

        if (!property_exists($this->caller, $propertyName))
            throw new InvalidArgumentException("property $name not exists");

        if ($this->$propertyName)
            return true;

        $FQCN                = str_replace('\\Service\\',
                                           '\\' . ucfirst($name) . '\\',
                                                          $this->caller);
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

    public function load($id)
    {
        $entity = $this->em()->find($this->entityName, (int)$id);

        if ($entity === null)
            return null;

        $this->entity = $entity;
        $this->setFormData($entity->getArrayCopy());

        return $entity;
    }

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
        $entity->setParent(null);
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
        $entity = $this->em()->find($this->entityName, (int)$id);
        ;
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
        $entity = $this->em()->find($this->entityName, (int)$id);
        if ($entity === null)
            return false;

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