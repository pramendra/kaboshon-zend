<?php

namespace Album\Model;

use Zend\Db\TableGateway\AbstractTableGateway;

class BugTable extends AbstractTableGateway
{
    protected $table = 'bugs';
}

