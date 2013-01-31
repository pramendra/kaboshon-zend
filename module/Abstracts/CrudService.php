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

        if (!$this->entityName && !$this->initNameEntity())
            throw new DomainException('entity name not correct');

        if (!$this->formName && !$this->initNameForm())
            throw new DomainException('form name not correct');

        return parent::onInit();
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

    public function __call($method, $argumetns)
    {
        if (strstr($method, 'initName')) {
            $name = substr($method, strlen('initName'));
            return $this->initName(lcfirst($name));
        }

        throw new \BadFunctionCallException("$method not found");
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