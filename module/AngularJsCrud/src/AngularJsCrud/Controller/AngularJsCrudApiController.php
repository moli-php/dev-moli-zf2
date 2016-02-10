<?php

namespace AngularJsCrud\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use AngularJsCrud\Model\Customers;
use AngularJsCrud\Model\Orders;
use AngularJsCrud\Model\Products;

class AngularJsCrudApiController extends AbstractActionController {

    protected $data;

    public function __construct() {
        $this->data = json_decode(file_get_contents("php://input"), true);
    }

    public function getCustomersAction() {
        $request = $this->getRequest();
        $response = array();
        $id = $this->params()->fromRoute('id', NULL);
        $sm = $this->getServiceLocator();
        if ($request->isGet()) {
            $angularTables = $sm->get('AngularJsCrud\Model\AngularTable');
            $response = $angularTables->getCustomers($id);
        }
        return new JsonModel($response);
    }

    public function getOrdersAction() {
        $request = $this->getRequest();
        $response = array();
        $id = $this->params()->fromRoute('id', NULL);
        $sm = $this->getServiceLocator();
        if ($request->isGet()) {
            $angularTables = $sm->get('AngularJsCrud\Model\AngularTable');
            $response = $angularTables->getOrders($id);
        }

        return new JsonModel($response);
    }

    public function getProductsAction() {
        $request = $this->getRequest();
        $response = array();
        $id = $this->params()->fromRoute('id', NULL);
        $sm = $this->getServiceLocator();
        if ($request->isGet()) {
            $angularTables = $sm->get('AngularJsCrud\Model\AngularTable');
            $response = $angularTables->getProducts($id);
        }

        return new JsonModel($response);
    }

    public function saveAction() {
        $request = $this->getRequest();
        $response = array();
        $id = $this->params()->fromRoute('id', NULL);
        $sm = $this->getServiceLocator();
        $angularTables = $sm->get('AngularJsCrud\Model\AngularTable');
        switch ($this->data['page']) {
            case 'customer' :
                $customer = new Customers();
                $customer->exchangeArray($this->data);
                $data = $customer->getArrayCopy();
                if ($id)
                    unset($data['id']);
                $result = $angularTables->save($id, $data, $this->data['page']);
                break;

            case 'order' :
                $order = new Orders();
                $order->exchangeArray($this->data);
                $data = $order->getArrayCopy();
                $result = $angularTables->save($id, $data, $this->data['page']);
                break;

            case 'product' :
                $product = new Products();
                $product->exchangeArray($this->data);
                $data = $product->getArrayCopy();
                if ($id)
                    unset($data['id']);
                $result = $angularTables->save($id, $data, $this->data['page']);
        }
        return new JsonModel(array('response' => $result));
    }

    public function deleteAction() {

        $table = $this->params()->fromRoute('page', NULL);
        $id = $this->params()->fromRoute('id', NULL);
        if ($this->getRequest()->isDelete()) {
            $sm = $this->getServiceLocator();
            $angularTables = $sm->get('AngularJsCrud\Model\AngularTable');
            $response = $angularTables->delete($id, $table);
        }

        return new JsonModel(array('response' => $response));
    }

}
