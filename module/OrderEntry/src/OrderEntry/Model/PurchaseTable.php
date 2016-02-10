<?php

namespace OrderEntry\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

class PurchaseTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getPurchases() {
//        $sql = $this->tableGateway->getSql();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array('cust' => 'customers'), 'cust.id = purchase.cust_id', array('first_name', 'last_name'), 'left')
                ->join(array('prod' => 'products'), 'prod.id = purchase.product_id', array('product'), 'left')
                ->join(array('pay' => 'payments'), 'pay.purchase_id = purchase.id', array(
                    'amount' => new Expression("ROUND(IFNULL(pay.amount,0),2)"),
                    'payment_id' => 'id',
                    'balance' => new Expression("ROUND((purchase.price * purchase.quantity) - IFNULL(pay.amount,0),2)")
                        ), 'left')
                ->order('purchase.date DESC');
//        echo $sql->getSqlstringForSqlObject($select); die ; 
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function getCustomerPurchase($id) {
        $select = $this->tableGateway->getSql()->select();
        $select->join(array('cust' => 'customers'), 'cust.id = purchase.cust_id', array('first_name', 'last_name'), 'left')
                ->join(array('prod' => 'products'), 'prod.id = purchase.product_id', array('product'), 'left')
                ->join(array('pay' => 'payments'), 'pay.purchase_id = purchase.id', array(
                    'amount' => new Expression("ROUND(IFNULL(pay.amount,0),2)"),
                    'payment_id' => 'id',
                    'balance' => new Expression("ROUND((purchase.price * purchase.quantity) - IFNULL(pay.amount,0),2)")
                        ), 'left')
                ->where(array('purchase.id' => $id));
        $resultSet = $this->tableGateway->selectWith($select)->current();
        return $resultSet;
    }

    public function getCustomerPurchases($id) {
//        $sql = $this->tableGateway->getSql();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array("prod" => "products"), "purchase.product_id = prod.id", array("product"), "left")
                ->join(array("pay" => "payments"), "purchase.id = pay.purchase_id", array("paid_amount" => "amount"), "left")
                ->where(array("purchase.cust_id" => $id))
                ->order("purchase.date DESC");
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function getCustomersPurchases() {
//        $sql = $this->tableGateway->getSql();
        $select = $this->tableGateway->getSql()->select();
        $select->join(array("prod" => "products"), "prod.id = purchase.product_id", array("product"), "left")
                ->join(array("pay" => "payments"), "pay.purchase_id = purchase.id", array("paid_amount" => "amount"), "left")
                ->join(array("cust" => "customers"), "cust.id = purchase.cust_id", array("first_name", "last_name", "credit_limit"), "left")
                ->order("purchase.cust_id ASC, purchase.date DESC");
//         echo $sql->getSqlstringForSqlObject($select); die ; 
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function getProductId($id) {
         $resultSet = $this->tableGateway->select(array('product_id' => $id));
         return $resultSet;
    }

    /* @
     * Status
     * 0 = not paid
     * 1 = paid
     * 2 patial
     */

    public function addPurchase($data) {
        return $this->tableGateway->insert($data);
//        return $this->tableGateway->getLastInsertValue();
    }

    public function updatePurchase($id, $data) {
        $data['date'] = date('Y-m-d H:i:s');
        return $this->tableGateway->update($data, array('id' => $id));
    }

    public function deleteCustomerId($id) {
        return $this->tableGateway->delete(array('cust_id' => $id));
    }

    public function deleteProductId($id) {
        return $this->tableGateway->delete(array('product_id' => $id));
    }

}