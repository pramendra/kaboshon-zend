<?php

namespace Album\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet as ResultSet;
use Zend\Stdlib\Hydrator\ArraySerializable as Hydrator;

/**
 * Description of UserTable
 *
 * @author Alexandr Generalov <ruderudebastrad at gmail.com>
 */
class UserTable extends AbstractTableGateway
{
    protected $table = 'users';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $resultSet = new ResultSet(
                        new Hydrator,
                        new User
        );

        $this->resultSetPrototype = $resultSet;
        $this->initialize();
    }
}

