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


    // $name . self::objectName
    const entityName = 'Entity';
    const formName = 'Form';
    const inputFilterName = 'Filter';

    /**
     * @var string FQCN of called class
     */
    protected $caller;

    /**
     * @var string module name, which called class placed
     */
    protected $moduleName;

    /**
     * @var string called class name without namespace and 'Service' substring
     */
    protected $serviceName;

    /**
     * @var mixed FQCN for entity, wich used in this service
     */
    protected $entityName;

    /**
     * @var string FQCN for entity, wich used in this service
     */
    protected $formName;

    /**
     * @var string FQCN for filter, wich used in this service
     */
    protected $filterName;

    /**
     * @var bool validation data result
     */
    protected $isValid;

    /**
     * @var int Items per page in listing items page
     */
    protected $rowsPerPage = 20;

    protected function getInputFilter()
    {
        return new $this->filterName;
    }

    /**
     * Create and return new form
     * @param $entity \Abstracts\Entity
     * @return \Zend\Form\Form
     */
    protected function getForm($entity = null)
    {
        $form = new $this->formName($this->em(), $entity);
        if ($this->filterName)
            $form->setInputFilter($this->getInputFilter());

        return $form;
    }

    /**
     * Create and return new entity
     * @param null|array $data
     * @return \Abstracts\Entity
     */
    protected function getEntity($data = null)
    {
        return new $this->entityName($data);
    }

    /**
     * Create and return new paginator object
     * @param \Doctrine\ORM\Tools\Pagination\Paginator $result Result to paginate
     * @return Paginator
     */
    protected function getPaginator($result)
    {
        return new Paginator(new PaginatorAdapter($result));
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
     * Init on the setting service locator event
     * @throws DomainException
     */
    protected function onInit()
    {
        $this->caller = get_called_class();

        // Calc namespace
        $this->moduleName = substr($this->caller, 0, strpos($this->caller, "\\"));

        // Calc service name
        $name = substr($this->caller, strrpos($this->caller, "\\") + 1);
        $this->serviceName = str_replace('Service', '', $name);

        if (!$this->entityName) {
            $this->entityName = $this->getEntityName();
            if (!$this->entityName)
                throw new DomainException('entity name not correct');
        }

        if (!$this->formName) {
            $this->filterName = $this->getFormName();
            if (!$this->filterName)
                throw new DomainException('form name not correct');
        }

        if (!$this->filterName)
            $this->filterName = $this->getInputFilter();

        return parent::onInit();
    }

    /**
     * get entity class name, which based of namespace and called class name
     * @return string
     */
    public function getEntityName()
    {
        $class = $this->moduleName . '\\' . self::entityName . '\\' . $this->serviceName;
        $class = class_exists($class)? $class: null;
        return $class;
    }

    /**
     * get form class name, which based of namespace and called class name
     * @return string
     */
    public function getFormName()
    {
        $class =  $this->moduleName . '\\' . self::formName . '\\' . $this->serviceName . self::formName;
        $class = class_exists($class)? $class: null;
        return $class;
    }

    /**
     * get input filter class name, which based if namespace and called class name
     * @return string
     */
    public function getInputFilterName()
    {
        $class = $this->namespace . '\\' . self::inputFilterName;
        return $this->namespace . '\\' . self::inputFilterName;
    }

    /**
     * Select entity by id
     */
    protected function findById($id)
    {
        return $this->em()->find($this->entityName, $id);
    }


    /**
     * Select entity by id and set 404, if entity not found
     * @see $this->findById
     * @param int $id
     * @return \Abstracts\Entity
     */
    protected function load($id)
    {
        $entity = $this->findById($id);

        if ($entity === null) {
            $this->sm()->get('response')->setStatusCode(404);
        } else
            return $entity;
    }
}