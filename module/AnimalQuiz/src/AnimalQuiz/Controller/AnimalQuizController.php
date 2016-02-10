<?php

namespace AnimalQuiz\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use AnimalQuiz\Model\Animals;

class AnimalQuizController extends AbstractActionController
{
    public function indexAction()
    {
        $layout_template = $this->params()->fromRoute('layout_template', NULL);
        $this->layout()->setTemplate($layout_template);
        return new ViewModel();
    }
    
    public function takeQuizAction() {
        $id = $this->params()->fromRoute('id', null);
        $request = $this->getRequest();
        $response = array();
        if($id && $request->isXmlHttpRequest()) {
            $animals = new Animals();
            $response = $animals->upTo($id);
        }else{
            $this->getResponse()->setStatusCode(404);
            $viewModel = new ViewModel();
            $viewModel->setTemplate('error/404');
            return $viewModel;
        }
        
         return new JsonModel($response);
    }
    
}
