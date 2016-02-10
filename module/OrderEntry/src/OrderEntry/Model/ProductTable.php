<?php

namespace OrderEntry\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;

class ProductTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getProducts() {
        $select = $this->tableGateway->getSql()->select();
        $select->order('date DESC');
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function getProduct($id) {
        $rowset = $this->tableGateway->select(array('id' => $id));
        return $rowset->current();
    }
    
    public function deleteProduct($id) {
        
        return $this->tableGateway->delete(array('id' => $id));
    }
    
    public function addProduct($data) {
        return $this->tableGateway->insert($data);
    }
    
    public function updateProduct($id,$data) {
        return $this->tableGateway->update($data, array('id' => $id));
    }


}