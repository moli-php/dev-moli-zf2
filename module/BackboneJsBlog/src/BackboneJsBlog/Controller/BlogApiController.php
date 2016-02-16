<?php

namespace BackboneJsBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use BackboneJsBlog\Model\Replies;
use BackboneJsBlog\Model\Blog;

class BlogApiController extends BaseController {

    public function apiAction() {

        $this->isAuth();
        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $form = $this->getServiceLocator()->get('BackboneJsBlogForm');
        $blogTable = $sm->get('BackboneJsBlog\Model\BlogTable');
        $blogService = $sm->get('BackboneJsBlog\Service\Blog');
        $replyTable = $sm->get('BackboneJsBlog\Model\BlogRepliesTable');
        $response = array();

        if ($request->isXmlHttpRequest()) {
            // save Blog
            if ($request->isPost()) {
                
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $blog = new Blog();
                    $blog->exchangeArray($form->getData());
                    if ($blogTable->saveBlog($blog)) {
                        $response = $blogService->getBlog();
                    }
                }
            // delete blog
            } elseif ($request->isDelete()) {
                $contents = json_decode($request->getContent(), true);
                $id = $this->params()->fromRoute('id', null);
                $response = array('result' => $blogTable->deleteBlog($id));
            // view blog
            } else {
                $response = $blogService->getBlog();
            }
        }
        return new JsonModel($response);
    }

    public function replyApiAction() {

        $this->isAuth();
        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $replyTable = $sm->get('BackboneJsBlog\Model\BlogRepliesTable');
        $form = $this->getServiceLocator()->get('BackboneJsBlogForm');
        $response = array();

        if ($request->isXmlHttpRequest()) {
            // save reply
            if ($request->isPost()) {
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $Replies = new Replies();
                    $Replies->exchangeArray($request->getPost());
                    $response = array('last_id' => $replyTable->saveReply($Replies));
                }
            // delete reply
            } elseif ($request->isDelete()) {
                $id = $this->params()->fromRoute('id', null);
                $response = array('result' => $replyTable->deleteReply($id));
            }
        }
        return new JsonModel($response);
    }

}