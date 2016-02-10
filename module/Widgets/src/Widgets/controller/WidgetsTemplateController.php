<?php

namespace Widgets\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WidgetsTemplateController extends AbstractActionController {
    
    public function youtubeItemAction() {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('YOUTUBE_IFRAME_ITEM');
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
     public function bbcNewsItemAction() {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('BBC_NEWS_ITEM');
        $viewModel->setTerminal(true);
        return $viewModel;
        
    }
}