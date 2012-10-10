<?php

namespace Album\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet as ResultSet;
use Zend\Stdlib\Hydrator\ArraySerializable as Hydrator;

class BugTable extends AbstractTableGateway
{
    protected $table = 'bugs';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $resultSet = new ResultSet(
                        new Hydrator,
                        new Bug
        );

        $this->resultSetPrototype = $resultSet;
        $this->initialize();
    }
}

