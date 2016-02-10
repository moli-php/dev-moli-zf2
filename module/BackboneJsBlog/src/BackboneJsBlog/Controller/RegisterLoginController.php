<?php

namespace BackboneJsBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use BackboneJsBlog\Model\Users;


class RegisterLoginController extends BaseController {

    public function loginAction() {
        
        if($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('backbone-js-blog');
        }

        $errMsg = '';
        $successMsg = $this->flashMessenger()->getSuccessMessages();
        $request = $this->getRequest();
        $form = $this->getServiceLocator()->get('BackboneJsBlogLoginForm');
        
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                
                $this->getAuthService()->getAdapter()
                        ->setIdentity($data['email'])
                        ->setCredential($data['password']);
                
                $result = $this->getAuthService()->authenticate();
                if($result->isValid()){
                    
                     $resultRow = $this->getAuthService()->getAdapter()->getResultRowObject();
                      $this->getAuthService()->getStorage()->
                            write(array(
                                'username' => $resultRow->username,
                                'name' => $resultRow->name,
                                'id' => $resultRow->id
                            ));
                      return $this->redirect()->toRoute('backbone-js-blog');
                      
                }else{
                    $errMsg = 'Username or password is incorrect';
                }
            }
        }
        $this->layout()->setTemplate('BACKBONE_JS_BLOG_LAYOUT_TEMPLATE');
        $viewModel = new ViewModel();
        $viewModel->setVariables(compact('form', 'successMsg', 'errMsg'));
        return $viewModel;

    }

    public function registerAction() {
        $sm =  $this->getServiceLocator();
        $form = $sm->get('BackboneJsBlogRegisterForm');
        $usersTable = $sm->get('BackboneJsBlog\Model\UsersTable');
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $data = $form->getData();
                $users = new Users();
                $users->exchangeArray($data);
                if($usersTable->getUsername($users->username)){
                    $form->get('username')->setMessages(array('Email is taken.'));
                }else{
                    if($usersTable->saveUser($users)){
                        $this->flashMessenger()->addSuccessMessage('Registration success...');
                        return $this->redirect()->toRoute('backbone-js-blog-register-login', array('action' => 'login'));
                    }
                }
            }
        }
        $this->layout()->setTemplate('BACKBONE_JS_BLOG_LAYOUT_TEMPLATE');
        $viewModel = new ViewModel();
        $viewModel->setVariables(compact('form'));
        return $viewModel;
    }
    
    public function logoutAction() {
        if ($this->getAuthService()->hasIdentity()) {
            $this->getAuthService()->clearIdentity();
        }
        return $this->redirect()->toRoute('backbone-js-blog-register-login', array('action' => 'login'));
    }

}