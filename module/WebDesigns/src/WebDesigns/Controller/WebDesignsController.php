<?php

namespace WebDesigns\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class WebDesignsController extends AbstractActionController
{
    public function designOneAction() {
        $this->layout()->setTemplate('DESIGN_ONE_LAYOUT');
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return new ViewModel();
    }
    
    public function designTwoAction() {
        $this->layout()->setTemplate('DESIGN_TWO_LAYOUT');
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return new ViewModel();
    }
    
    public function designThreeAction() {
        
        $this->layout()->setTemplate('DESIGN_THREE_LAYOUT');
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return new ViewModel();
    }
    public function designFourAction() {
        
        $this->layout()->setTemplate('DESIGN_FOUR_LAYOUT');
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return new ViewModel();
    }
    public function designFiveAction() {
        
        $this->layout()->setTemplate('DESIGN_FIVE_LAYOUT');
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return new ViewModel();
    }
    
    
}
