<?php

namespace OrderEntry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use OrderEntry\Model\Customer;
use OrderEntry\Model\Product;
use OrderEntry\Model\Purchase;
use OrderEntry\Model\Payments;

class OrderEntryApiController extends AbstractActionController {

    public function addCustomerAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $form = $sm->get('customerForm');

        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $customer = new Customer();
                $customer->exchangeArray($form->getData());
                $customerTable = $sm->get('OrderEntry\Model\Customer');
                if ($customerTable->addCustomer($customer->getArrayCopy()) == 1) {
                    $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data saved.');
                }
            } else {
                $response = array('response' => 400, 'status' => 'Bad Request', 'message' => $form->getMessages());
            }
        }

        return new JsonModel($response);
    }

    public function addProductAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $form = $sm->get('productForm');

        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $product = new Product();
                $product->exchangeArray($form->getData());
                $productTable = $sm->get('OrderEntry\Model\Product');
                if ($productTable->addProduct($product->getArrayCopy()) == 1) {
                    $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data saved.');
                }
            } else {
                $response = array('response' => 400, 'status' => 'Bad Request', 'message' => $form->getMessages());
            }
        }

        return new JsonModel($response);
    }

    public function addPurchaseAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();

        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $purchase = new Purchase();
            $purchase->exchangeArray($request->getPost());
            $data = $purchase->getArrayCopy();
            $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
            if ($purchaseTable->addPurchase($purchase->getArrayCopy()) == 1) {
                $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data saved.');
            } else {
                $response = array('response' => 500, 'status' => 'Internal Server Error', 'message' => 'Data not save.');
            }
        }

        return new JsonModel($response);
    }

    public function addPaymentAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();

        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $payments = new Payments();
            $payments->exchangeArray($request->getPost());
            $data = $payments->getArrayCopy();
            $paymentsTable = $sm->get('OrderEntry\Model\Payments');
            if ($paymentsTable->addPayment($payments->getArrayCopy()) == 1) {
                $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data saved.');
            } else {
                $response = array('response' => 500, 'status' => 'Internal Server Error', 'message' => 'Data not save.');
            }
        }

        return new JsonModel($response);
    }

    public function updatePurchaseAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('id', null);

        if ($request->isPut() && $request->isXmlHttpRequest() && $id) {

            parse_str(file_get_contents('php://input'), $data);
            $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
            if ($purchaseTable->updatePurchase($id, $data) == 1) {
                $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data not save.');
            } else {
                $response = array('response' => 500, 'status' => 'Internal Server Error', 'message' => 'Data not save.');
            }
        }

        return new JsonModel($response);
    }

    public function updatePaymentAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('id', null);

        if ($request->isPut() && $request->isXmlHttpRequest() && $id) {

            parse_str(file_get_contents('php://input'), $data);
            $paymentsTable = $sm->get('OrderEntry\Model\Payments');
            if ($paymentsTable->updatePayment($id, $data) == 1) {
                $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data not save.');
            } else {
                $response = array('response' => 500, 'status' => 'Internal Server Error', 'message' => 'Data not save.');
            }
        }
        return new JsonModel($response);
    }

    public function deleteCustomerAction() {
        
        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $customerTable = $sm->get('OrderEntry\Model\Customer');
        $paymentsTable = $sm->get('OrderEntry\Model\Payments');
        $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
        parse_str(file_get_contents('php://input'), $data);
        $id = $data['id'];
        if ($request->isDelete() && $request->isXmlHttpRequest()) {
            $paymentsTable->deleteCustomerId($id);
            $purchaseTable->deleteCustomerId($id);
            if ($customerTable->deleteCustomer($id) == 1) {
                $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Date deleteds.');
            } else {
                $response = array('response' => 500, 'status' => 'Internal Server Error', 'message' => 'Data not deleted.');
            }
        }

        return new JsonModel($response);
    }

    public function updateCustomerAction() {
        $sm = $this->getServiceLocator();
        $id = $this->params()->fromRoute('id', null);
        $request = $this->getRequest();
        parse_str(file_get_contents('php://input'), $data);
        $form = $sm->get('customerForm');
        $customer = new Customer();
        if ($request->isPut() && $request->isXmlHttpRequest() && $id) {
            $form->setData($data);
            if ($form->isValid()) {
                $customerTable = $sm->get('OrderEntry\Model\Customer');
                $customer->exchangeArray($form->getData());
                $data = $customer->getArrayCopy();
                unset($data['id']);
                if ($customerTable->updateCustomer($id, $data) == 1) {
                    $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data saved.');
                }
            } else {
                $response = array('response' => 400, 'status' => 'Bad Request', 'message' => $form->getMessages());
            }
        }

        return new JsonModel($response);
    }

    public function deleteProductAction() {
        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $paymentsTable = $sm->get('OrderEntry\Model\Payments');
        $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
        $productTable = $sm->get('OrderEntry\Model\Product');

        if ($request->isDelete() && $request->isXmlHttpRequest()) {

            parse_str(file_get_contents('php://input'), $data);
            $id = $data['id'];
            $resultSet = $purchaseTable->getProductId($id);
            $i = 0;
            if (count($resultSet)) {
                foreach ($resultSet as $val) {
                    $paymentsTable->deletePurchaseId($val->id);
                }
            }
            $purchaseTable->deleteProductId($id);

            if ($productTable->deleteProduct($id) == 1) {
                $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data deleted.');
            } else {
                $response = array('response' => 500, 'status' => 'Internal Server Error', 'message' => 'Data not deleted.');
            }
        }

        return new JsonModel($response);
    }

    public function updateProductAction() {
        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('id', null);
        $form = $sm->get('productForm');

        if ($request->isPut() && $request->isXmlHttpRequest() && $id) {
            parse_str(file_get_contents('php://input'), $data);

            $form->setData($data);
            if ($form->isValid()) {
                $product = new Product();
                $product->exchangeArray($form->getData());
                $productTable = $sm->get('OrderEntry\Model\Product');
                $data = $product->getArrayCopy();
                unset($data['id']);
                if ($productTable->updateProduct($id, $data) == 1) {
                    $response = array('response' => 200, 'status' => 'Ok', 'message' => 'Data updated.');
                } else {
                    $response = array('response' => 500, 'status' => 'Internal Server Error', 'message' => 'Data not updated.');
                }
            } else {
                $response = array('response' => 400, 'status' => 'Bad Request', 'message' => $form->getMessages());
            }
        }
        
        return new JsonModel($response);
    }

}