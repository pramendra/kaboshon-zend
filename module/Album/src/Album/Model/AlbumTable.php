<?php

namespace Album\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\HydratingResultSet as ResultSet;
use Zend\Stdlib\Hydrator\ArraySerializable as Hydrator;

class AlbumTable extends AbstractTableGateway
{

    protected $table = 'album';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $resultSet = new ResultSet(
                        new Hydrator,
                        new Album
        );

        $this->resultSetPrototype = $resultSet;
        $this->initialize();
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getAlbum($id)
    {
        $id     = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveAlbum(Album $album)
    {
        $id   = (int) $album->getId();
        $data = $album->getdata();        
        
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteAlbum($id)
    {
        $this->delete(array('id' => $id));
    }

}