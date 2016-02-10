<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        /* set OrderEntry Module variables */
        $application = $e->getApplication();
        $application->getEventManager()->getSharedManager()
                ->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', 
                        function($e) {
                            $controller = $e->getTarget();
                            $controllerClass = get_class($controller);
                            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
//                            $controllerName = substr($controllerClass,  strrpos($controllerClass, '\\') + 1, strlen($controllerClass));
                            $sm = $e->getApplication()->getServiceManager();
                            $config = $sm->get('config');
                            if ($moduleNamespace == 'OrderEntry') {
                                if (isset($config['view_manager']['module_layouts']['order_entry'])) {
                                    $layoutTemplate = $config['view_manager']['module_layouts']['order_entry'];
                                    $request = $controller->getRequest();
                                    $getUriPath = trim($request->getUri()->getPath(), '/');
                                    $layout = $controller->layout();
                                    $layoutData['uri_path'] = $getUriPath;
                                    $layoutData['page'] = $controller->params()->fromRoute('action', NULL) == 'index' 
                                            ? 'customer' : $controller->params()->fromRoute('action', NULL);
                                    $layout->setVariables($layoutData);
                                    $layout->setTemplate($layoutTemplate);
                                }
                            }
                            
                          
                         
                        }
        );
        
        /* set variables to all layouts */
        $sm = $application->getServiceManager();
        $config = $sm->get('Configuration');
        $viewModel = $application->getMvcEvent()->getViewModel();
        $viewModel->setVariables(array('url_config' => $config['url_config']));
        
        
    }
    

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
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
}
