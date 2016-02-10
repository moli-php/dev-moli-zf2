<?php

namespace BackboneJsBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;


class BaseController extends AbstractActionController {

    protected $authService;
    protected $storage;

    public function getAuthService() {
        if(!$this->authService){
            $this->authService = $this->getServiceLocator()->get('BlogAuthService');
        }
        return $this->authService;
    }
    
    // this has never been used for now
    public function getSessionStorage() {
        if(!$this->storage){
            $this->storage = $this->getServiceLocator()->get('BlogAuthStorage');
        }
        return $this->storage;
    }

    public function isAuth() {

        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('backbone-js-blog-register-login', array('action' => 'login'));
        }
    }
    
}