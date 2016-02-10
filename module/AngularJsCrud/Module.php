<?php

namespace AngularJsCrud;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\StdLib\Hydrator\ObjectProperty;
use Zend\Db\TableGateway\TableGateway;
use AngularJsCrud\Model\Customers as Customers;
use AngularJsCrud\Model\Orders as Orders;
use AngularJsCrud\Model\Products as Products;
use AngularJsCrud\Model\AngularTables;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
//            'Zend\Loader\ClassMapAutoloader' => array(
//                __DIR__ . '/autoload_classmap.php'
//            ),
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
                'AngularJsCrudCustomerGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new HydratingResultSet();
                    $resultSetProto->setHydrator(new ObjectProperty());
                    $resultSetProto->setObjectPrototype(new Customers());
                    return new TableGateway('angular_js_customers', $dbAdapter, null, $resultSetProto);
                },
                'AngularJsCrudProductsGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new HydratingResultSet();
                    $resultSetProto->setHydrator(new ObjectProperty());
                    $resultSetProto->setObjectPrototype(new Products());
                    return new TableGateway('angular_js_products', $dbAdapter, null, $resultSetProto);
                },
                'AngularJsCrudOrdersGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new HydratingResultSet();
                    $resultSetProto->setHydrator(new ObjectProperty());
                    $resultSetProto->setObjectPrototype(new Orders());
                    return new TableGateway('angular_js_orders', $dbAdapter, null, $resultSetProto);
                },
                'AngularJsCrud\Model\AngularTable' => function($sm) {
                    $customersGateway = $sm->get('AngularJsCrudCustomerGateway');
                    $productsGateway = $sm->get('AngularJsCrudProductsGateway');
                    $ordersGateway = $sm->get('AngularJsCrudOrdersGateway');
                    return new AngularTables($customersGateway,$ordersGateway,$productsGateway);
                }
            ),
            'invokables' => array(
                'calendarForm' => 'CalendarScheduler\Form\CalendarForm'
            )
        );
    }
}
