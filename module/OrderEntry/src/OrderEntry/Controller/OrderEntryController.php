<?php

namespace OrderEntry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrderEntryController extends AbstractActionController {
    
    public function indexAction() {
        $sm = $this->getServiceLocator();
        $customerTable = $sm->get('OrderEntry\Model\Customer');
        $viewData['customers'] = $customerTable->getCustomers();
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
    }

    public function productAction() {
        $sm = $this->getServiceLocator();
        $productTable = $sm->get('OrderEntry\Model\Product');
        $viewData['products'] = $productTable->getProducts();
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
    }

    public function profileAction() {

        $id = $this->params()->fromRoute('id', NULL);
        $sm = $this->getServiceLocator();
        $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
        $customerTable = $sm->get('OrderEntry\Model\Customer');
        $paymentsTable = $sm->get('OrderEntry\Model\Payments');
        $viewData['customer'] = $customerTable->getCustomer($id);
        $viewData['customers'] = $customerTable->getCustomers();
        $viewData['getPurchases'] = $purchaseTable->getCustomerPurchases($id);
        $viewData['getCustomerPayments'] = $paymentsTable->getCustomerPayments($id);
        $viewData['profile'] = $customerTable->getCustomer($id);
        $viewData['id'] = $id;
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
    }

    public function paymentByDateAction() {
        $sm = $this->getServiceLocator();
        $paymentsTable = $sm->get('OrderEntry\Model\Payments');
        $viewData['payments'] = $paymentsTable->getPayments();
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
    }

    public function paymentByNameAction() {

        $sm = $this->getServiceLocator();
        $paymentService = $sm->get('OrderEntry\Service\PaymentService');
        $viewData['customersPayments'] = $paymentService->getCustomersPayments();
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
    }

    public function purchaseByDateAction() {

        $sm = $this->getServiceLocator();
        $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
        $viewData['purchases'] = $purchaseTable->getPurchases();
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
    }

    public function purchaseByNameAction() {
        //getCustomersPurchases
        $sm = $this->getServiceLocator();
        $purchaseService = $sm->get('OrderEntry\Service\PurchaseService');
        $viewData['customersPurchases'] = $purchaseService->getCustomersPurchases();
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
    }

    public function addCustomerAction() {
        $sm = $this->getServiceLocator();
        $form = $sm->get('customerForm');
        $id = $this->params()->fromRoute('id', NULL);
        $viewData['form'] = $form;
        $viewData['id'] = $id;
        $customerTable = $sm->get('OrderEntry\Model\Customer');
        $viewData['customer'] = $customerTable->getCustomer($id);
        $viewModel = new ViewModel($viewData);
        return $viewModel;
    }

    public function addProductAction() {
        $sm = $this->getServiceLocator();
        $form = $sm->get('productForm');
        $viewData['form'] = $form;
        $id = $this->params()->fromRoute('id', NULL);
        $productTable = $sm->get('OrderEntry\Model\Product');
        $viewData['product'] = $productTable->getProduct($id);
        $viewData['id'] = $id;
        $viewModel = new ViewModel($viewData);
        return $viewModel;
    }

    public function addOrderAction() {
        $sm = $this->getServiceLocator();
        $productTable = $sm->get('OrderEntry\Model\Product');
        $customerTable = $sm->get('OrderEntry\Model\Customer');
        $viewData['id'] = $this->params()->fromRoute('id', NULL);
        $viewData['getCustomerInfo'] = $customerTable->getCustomerInfos($viewData['id']);
        $viewData['getCustomersInfo'] = $customerTable->getCustomerInfos();
        $viewData['products'] = $productTable->getProducts();
        $viewModel = new ViewModel($viewData);
        return $viewModel;
    }
    
    public function deleteCustomerAction() {
        $sm = $this->getServiceLocator();
        $customerTable = $sm->get('OrderEntry\Model\Customer');
        $id = $this->params()->fromRoute('id', NULL);
        $viewData['customer'] = $customerTable->getCustomer($id);
        $viewData['customers'] = $customerTable->getCustomers();
        $viewModel = new ViewModel($viewData);
        return $viewModel;
        
    }
    public function deleteProductAction() {
        $sm = $this->getServiceLocator();
        $productTable = $sm->get('OrderEntry\Model\Product');
        $id = $this->params()->fromRoute('id', NULL);
        $viewData['product'] = $productTable->getProduct($id);
        $viewData['products'] = $productTable->getProducts();
        $viewModel = new ViewModel($viewData);
        return $viewModel;
        
    }
    
    public function customerPaymentAction() {
        $sm = $this->getServiceLocator();
        $id = $this->params()->fromRoute('id', NULL);
        $purchaseService = $sm->get('OrderEntry\Service\PurchaseService');
        $viewData['customersPurchases'] = $purchaseService->getCustomersPurchases();
        if($id) {
            $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
            $viewData['customerPurchase'] = $purchaseTable->getCustomerPurchase($id);
        }
        
        $viewData['id'] = $id;
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
        
    }
}
