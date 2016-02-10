<?php

namespace AngularJsCrud\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AngularJsCrudTemplateController extends AbstractActionController {

    protected function _viewModel($template = NULL, $data = NULL) {
        $viewModel = new ViewModel();
        if ($template) {
            $viewModel->setTemplate($template);
        }
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function customersAction() {
        return $this->_viewModel();
    }

    public function ordersAction() {
        return $this->_viewModel();
    }

    public function ordersTableAction() {
        return $this->_viewModel();
    }

    public function productsAction() {
        return $this->_viewModel();
    }

    public function profileAction() {
        return $this->_viewModel();
    }

    public function actionAction() {
        return $this->_viewModel();
    }

    public function addCustomerAction() {
        return $this->_viewModel('ANGULAR_JS_CUSTOMER_FORM_TEMPLATE');
    }

    public function addProductAction() {
        return $this->_viewModel('ANGULAR_JS_PRODUCT_FORM_TEMPLATE');
    }

    public function addOrderAction() {
        return $this->_viewModel('ANGULAR_JS_ORDER_FORM_TEMPLATE');
    }

}