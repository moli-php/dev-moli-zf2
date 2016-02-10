<?php

namespace OrderEntry\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;


class CustomerTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getCustomers() {
//        $sql = $this->tableGateway->getSql();
        $select = $this->tableGateway->getSql()->select();
        $select->order('first_name ASC');
//        echo $sql->getSqlstringForSqlObject($select); die ; 
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function getCustomer($id) {
        $resultSet = $this->tableGateway->select(array('id' => $id));
        return $resultSet->current();
    }
    
    public function getCustomerInfos($id = null) {
//        $sql = $this->tableGateway->getSql();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array('pur' => 'purchase'), 'pur.cust_id = customers.id', 
                array('balance' => 
                    new Expression('CASE WHEN !ISNULL(pay.amount) 
                        THEN (SUM(pur.amount) - SUM(pay.amount)) ELSE SUM(pur.amount) END')),
                'left')
                ->join(array('pay' => 'payments'), 'pay.purchase_id = pur.id',array(),'left');
                if($id){
                    $select->where(array('customers.id' => $id));
                }
                $select->group(array('customers.id'));
//                echo $sql->getSqlstringForSqlObject($select); die ; 
                $resultSet = $this->tableGateway->selectWith($select);
                if($id) {
                    $resultSet = $this->tableGateway->selectWith($select)->current();
                }
        
        return $resultSet;
    }
    
    public function deleteCustomer($id) {
        return $this->tableGateway->delete(array('id' => $id));
    }
    
    public function addCustomer($data) {
        return $this->tableGateway->insert($data);
    }
    
    public function updateCustomer($id, $data) {
        $data['date'] = date('Y-m-d H:i:s');
        return $this->tableGateway->update($data, array('id' => $id));
    }
    




}