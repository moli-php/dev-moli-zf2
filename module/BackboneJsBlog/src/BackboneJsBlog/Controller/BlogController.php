<?php

namespace BackboneJsBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use BackboneJsBlog\Model\Replies;

class BlogController extends BaseController {


    public function indexAction() {
        
        $this->isAuth();
        
        $identity = $this->getAuthService()->getIdentity();
       
        $sm = $this->getServiceLocator();
        $blog = $sm->get('BackboneJsBlog\Service\Blog');

        $data['username'] = $identity['username'];
        $data['user_id'] = $identity['id'];
        $data['name'] = $identity['name'];
        $data['form'] = $sm->get('BackboneJsBlogForm');
        $data['searchForm'] = $sm->get('BackboneJsBlogSearchForm');
        $data['forum'] = $blog->getBlog();
        $this->layout()->setTemplate('BACKBONE_JS_BLOG_LAYOUT_TEMPLATE');

        return new ViewModel($data);
        
    }
    
    


}