<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MainController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout()->setVariable('page', $this->params()->fromRoute('action'));
        return new ViewModel();
    }
    
    public function samplesAction() {
        $this->layout()->setVariable('page', $this->params()->fromRoute('action'));
        return new ViewModel();
    }
    
    public function aboutAction() {
        $this->layout()->setVariable('page', $this->params()->fromRoute('action'));
        return new ViewModel();
    }
}
