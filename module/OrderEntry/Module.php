<?php

namespace OrderEntry;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\StdLib\Hydrator\ObjectProperty;
use Zend\Db\TableGateway\TableGateway;
use OrderEntry\Model\Customer;
use OrderEntry\Model\CustomerTable;
use OrderEntry\Model\Product;
use OrderEntry\Model\ProductTable;
use OrderEntry\Model\Purchase;
use OrderEntry\Model\PurchaseTable;
use OrderEntry\Model\Payments;
use OrderEntry\Model\PaymentsTable;
use OrderEntry\Service\PaymentService;
use OrderEntry\Service\PurchaseService;

class Module {

   

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'CustomerGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new ResultSet();
                    $resultSetProto->setArrayObjectPrototype(new Customer());
                    return new TableGateway('customers', $dbAdapter);
                },
                'OrderEntry\Model\Customer' => function($sm) {
                    $tableGateway = $sm->get('CustomerGateway');
                    return new CustomerTable($tableGateway);
                },
                'ProductGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new ResultSet();
                    $resultSetProto->setArrayObjectPrototype(new Product());
                    return new TableGateway('products', $dbAdapter);
                },
                'OrderEntry\Model\Product' => function($sm) {
                    $tableGateway = $sm->get('ProductGateway');
                    return new ProductTable($tableGateway);
                },
                'PurchaseGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new HydratingResultSet();
                    $resultSetProto->setHydrator(new ObjectProperty());
                    $resultSetProto->setObjectPrototype(new Purchase());
                    return new TableGateway('purchase', $dbAdapter, null, $resultSetProto);
                },
                'OrderEntry\Model\Purchase' => function($sm) {
                    $tableGateway = $sm->get('PurchaseGateway');
                    return new PurchaseTable($tableGateway);
                },
                'PaymentsGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new HydratingResultSet();
                    $resultSetProto->setHydrator(new ObjectProperty());
                    $resultSetProto->setObjectPrototype(new Purchase());
                    return new TableGateway('payments', $dbAdapter, null, $resultSetProto);
                },
                'OrderEntry\Model\Payments' => function($sm) {
                    $tableGateway = $sm->get('PaymentsGateway');
                    return new PaymentsTable($tableGateway);
                },
                'OrderEntry\Service\PaymentService' => function($sm) {
                    $paymentTable = $sm->get('OrderEntry\Model\Payments');
                    $customerTable = $sm->get('OrderEntry\Model\Customer');
                    return new PaymentService($paymentTable, $customerTable);
                },
                'OrderEntry\Service\PurchaseService' => function($sm) {
                    $purchaseTable = $sm->get('OrderEntry\Model\Purchase');
                    $customerTable = $sm->get('OrderEntry\Model\Customer');
                    return new PurchaseService($purchaseTable, $customerTable);
                }
            ),
            'invokables' => array(
                'customerForm' => 'OrderEntry\Form\CustomerForm',
                'productForm' => 'OrderEntry\Form\ProductForm',
                'orderForm' => 'OrderEntry\Form\OrderForm',
            )
        );
    }

    public function getViewHelperConfig() {
        return array(
            'invokables' => array(
                'formatDecimal' => 'OrderEntry\View\Helper\FormatDecimal'
            )
        );
    }

}
