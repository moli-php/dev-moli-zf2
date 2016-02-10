<?php

namespace OrderEntry\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Delete;

class PaymentsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getPayments() {
//        $sql = $this->tableGateway->getSql();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array("b" => "purchase"), "payments.purchase_id = b.id", array("quantity", "status", "price"), "left")
                ->join(array("c" => "products"), "b.product_id = c.id", array("product"), "left")
                ->join(array("d" => "customers"), "d.id = payments.cust_id", array("first_name", "last_name"), "left")
                ->order("payments.date DESC");
//        echo $sql->getSqlstringForSqlObject($select); die ; 
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function getCustomerPayments($id) {
//        $sql = $this->tableGateway->getSql();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array("b" => 'purchase'), "b.id = payments.purchase_id", array('quantity', 'status', 'price'))
                ->join(array('c' => 'products'), 'c.id = b.product_id', array('product'),'left')
                ->where(array('payments.cust_id' => $id))
                ->order('payments.date DESC');
//        echo $sql->getSqlstringForSqlObject($select); die ; 
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function addPayment($data) {
        return $this->tableGateway->insert($data);
    }

    public function updatePayment($id, $data) {
        return $this->tableGateway->update($data, array('id' => $id));
    }

    public function deleteCustomerId($id) {
        return $this->tableGateway->delete(array('cust_id' => $id));
    }
    
    public function deletePurchaseId($id) {
        return $this->tableGateway->delete(array('purchase_id' => $id));
    }
    
    public function deletePurchaseIds($aId) {
        if($aId) {
            foreach($aId as $purchase_id) {
                 $this->tableGateway->delete(array('purchase_id' => $purchase_id));
            }
        }
       
    }
    

}