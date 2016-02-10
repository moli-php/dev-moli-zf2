<?php

namespace Widgets\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WidgetsController extends AbstractActionController {
    
    public function youtubeAction() {
        $this->layout()->setTemplate('YOUTUBE_LAYOUT_TEMPLATE');
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function youtubeItemAction() {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('YOUTUBE_IFRAME_ITEM');
        $viewModel->setTerminal(true);
        return $viewModel;
        
    }
    
    public function analogClockAction() {
        $this->layout()->setTemplate('ANALOG_CLOCK_LAYOUT_TEMPLATE');
        $viewModel = new ViewModel();
        return $viewModel;
    }
    
    public function bbcNewsAction() {
        $this->layout()->setTemplate('BBC_NEWS_LAYOUT_TEMPLATE');
        $request = $this->getRequest();
        
        $sm = $this->getServiceLocator();
        $bbcNewsService = $sm->get('BbcNewsService');
        $viewData['categories'] = $bbcNewsService->category();
        $viewData['feeds'] = $bbcNewsService->getFeed('News');
       
        $viewModel = new ViewModel();
        $viewModel->setVariables($viewData);
        return $viewModel;
        
    }
    
     public function bbcNewsItemAction() {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('BBC_NEWS_ITEM');
        $viewModel->setTerminal(true);
        return $viewModel;
        
    }
}