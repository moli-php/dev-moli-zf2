<?php

namespace AngularJsCrud\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class AngularJsCrudController extends AbstractActionController
{
    public function indexAction()
    {
        $layout_template = $this->params()->fromRoute('layout_template', NULL);
        $this->layout()->setTemplate($layout_template);
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
}
