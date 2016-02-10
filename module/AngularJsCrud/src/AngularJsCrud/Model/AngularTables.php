<?php

namespace AngularJsCrud\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;

class AngularTables {

    protected $customersTableGateway;
    protected $ordersTableGateway;
    protected $productsTableGateway;

    public function __construct($customersTableGateway, $ordersTableGateway, $productsTableGateway) {
        $this->customersTableGateway = $customersTableGateway;
        $this->ordersTableGateway = $ordersTableGateway;
        $this->productsTableGateway = $productsTableGateway;
    }

    public function getCustomers($id = NULL) {
        if ($id) {
            $customer = $this->customersTableGateway->select(array('id' => $id))->toArray();
            $resultSet = $customer[0];
        } else {
            $resultSet = $this->customersTableGateway->select();
        }
        return $resultSet;
    }

    public function getOrders($id = NULL) {

        $customers = $this->getCustomers($id);
        if ($id) {
            $customers['orders'] = $this->_getCustomerOrders($customers['id'])->toArray();
        } else {
            $customers = $this->getCustomers()->toArray();
            foreach ($customers as $key => $val) {
                $customers[$key]['orders'] = $this->_getCustomerOrders($val['id'])->toArray();
            }
        }
        return $customers;
    }

    private function _getCustomerOrders($id = NULL) {
        if ($id) {
            $select = $this->ordersTableGateway->getSql()->select();
            $select->join(array('b' => 'angular_js_products'), 'b.id = angular_js_orders.product_id', array('product', 'price'), 'left')
                    ->where(array('angular_js_orders.cust_id' => $id));
            $resultSet = $this->ordersTableGateway->selectWith($select);
            return $resultSet;
        }
    }

    public function getProducts($id = NULL) {

        if ($id) {
            $resultSet = $this->productsTableGateway->select(array('id' => $id));
            $product = $resultSet->toArray();
            $resultSet = $product[0];
        } else {
            $resultSet = $this->productsTableGateway->select();
        }
        return $resultSet;
    }

    public function save($id = NULL, $data = array(), $table) {
        switch ($table) {
            case 'customer' :
                return $this->_saveCustomer($data, $id);
                break;

            case 'order' :
                return $this->_saveOrder($data);
                break;

            case 'product' :
                return $this->_saveProduct($data, $id);
        }
    }

    private function _saveCustomer($data, $id = NULL) {

        if ($id) {
            return $this->customersTableGateway->update($data, array('id' => $id));
        } else {
            return $this->customersTableGateway->insert($data);
        }
    }

    private function _saveProduct($data, $id = NULL) {

        if ($id) {
            return $this->productsTableGateway->update($data, array('id' => $id));
        } else {
            return $this->productsTableGateway->insert($data);
        }
    }

    private function _saveOrder($data) {
        return $this->ordersTableGateway->insert($data);
    }

    public function delete($id = NULL, $table) {
        if ($id) {
            if ($table == 'customer') {
                $this->ordersTableGateway->delete(array('cust_id' => $id));
                return $this->customersTableGateway->delete(array('id' => $id));
            } else if ($table == 'product') {
                $this->ordersTableGateway->delete(array('product_id' => $id));
                return $this->productsTableGateway->delete(array('id' => $id));
            }
        }
    }

}