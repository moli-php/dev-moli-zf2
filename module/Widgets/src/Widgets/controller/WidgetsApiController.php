<?php

namespace Widgets\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class WidgetsApiController extends AbstractActionController {
    
   
    public function bbcNewsAction() {
        
        $response = array();
        $request = $this->getRequest();
         $sm = $this->getServiceLocator();
        
        if($request->isPost() && $request->isXmlHttpRequest()) {
            $bbcNewsService = $sm->get('BbcNewsService');
            $response = $bbcNewsService->getFeed($request->getPost('name'));
        }
        
       return new JsonModel($response);
        
    }
}