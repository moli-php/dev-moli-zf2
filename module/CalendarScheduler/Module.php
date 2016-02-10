<?php

namespace CalendarScheduler;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use CalendarScheduler\Model\Calendar;
use CalendarScheduler\Model\CalendarTable;

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
                'CalendarGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new ResultSet();
                    $resultSetProto->setArrayObjectPrototype(new Calendar());
                    return new TableGateway('calendar', $dbAdapter);
                },
                'Calendar\Model\CalendarTable' => function($sm) {
                    $tableGateway = $sm->get('CalendarGateway');
                    return new CalendarTable($tableGateway);
                }
            ),
            'invokables' => array(
                'calendarForm' => 'CalendarScheduler\Form\CalendarForm'
            )
        );
    }

}
