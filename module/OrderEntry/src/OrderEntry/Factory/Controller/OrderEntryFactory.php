<?php

namespace OrderEntry\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use OrderEntry\Controller\OrderEntryController;
use Zend\Mvc\ApplicationInterface;


class OrderEntryFactory implements FactoryInterface
{
   
    public function createService(ServiceLocatorInterface $sm) {
   
        $controller = new OrderEntryController($sm);
        
        return $controller;
        
    }
    
 

    
}
