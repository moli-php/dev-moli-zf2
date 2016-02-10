<?php

namespace BackboneJsBlog;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\StdLib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\ResultSet;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

use BackboneJsBlog\Storage\AuthStorage;
use BackboneJsBlog\Service\BlogService;
use BackboneJsBlog\Model\UsersTable;
use BackboneJsBlog\Model\BlogTable;
use BackboneJsBlog\Model\RepliesTable;
use BackboneJsBlog\Model\Blog;
use BackboneJsBlog\Model\Users;
use BackboneJsBlog\Model\Replies;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {

        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(

                'BackboneJsUsersGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new ResultSet();
                    $resultSetProto->setArrayObjectPrototype(new Users());
                    return new TableGateway('backbone_blog_users', $dbAdapter, null, $resultSetProto);
                },
                'BackboneJsBlogGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new HydratingResultSet(); 
                    $resultSetProto->setHydrator(new ObjectProperty());
                    $resultSetProto->setObjectPrototype(new Blog());
                    return new TableGateway('backbone_blog', $dbAdapter, null, $resultSetProto);
                },
                'BackboneJsBlogRepliesGateway' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $resultSetProto = new HydratingResultSet(); 
                    $resultSetProto->setHydrator(new ObjectProperty());
                    $resultSetProto->setObjectPrototype(new Replies());
                    return new TableGateway('backbone_blog_replies', $dbAdapter, null, $resultSetProto);
                },
                'BackboneJsBlog\Model\UsersTable' => function($sm) {
                    $tableGateway = $sm->get('BackboneJsUsersGateway');
                    return new UsersTable($tableGateway);
                },
                'BackboneJsBlog\Model\BlogTable' => function($sm) {
                    $tableGateway = $sm->get('BackboneJsBlogGateway');
                    return new BlogTable($tableGateway);
                },
                'BackboneJsBlog\Model\BlogRepliesTable' => function($sm) {
                    $tableGateway = $sm->get('BackboneJsBlogRepliesGateway');
                    return new RepliesTable($tableGateway);
                },
                'BackboneJsBlog\Service\Blog' => function($sm) {
                    $blog = $sm->get('BackboneJsBlog\Model\BlogTable');
                    $replies = $sm->get('BackboneJsBlog\Model\BlogRepliesTable');
                    
                    $blogService = new BlogService($blog,$replies);
                    return $blogService;
                    
                },
                'BlogAuthStorage' => function($sm) {
                    return new AuthStorage('user_storage');
                },
                'BlogAuthService' => function($sm) {
                    $dbAdapter = $sm->get('site_db');
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 
                                            'backbone_blog_users','username','password', 'MD5(?)');
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('BlogAuthStorage'));
                    return $authService;
                    
                }
            ),
            'invokables' => array(
                'BackboneJsBlogLoginForm' => 'BackboneJsBlog\Form\LoginForm',
                'BackboneJsBlogRegisterForm' => 'BackboneJsBlog\Form\RegisterForm',
                'BackboneJsBlogForm' => 'BackboneJsBlog\Form\BlogForm',
                'BackboneJsBlogSearchForm' => 'BackboneJsBlog\Form\SearchForm',
                
            )
        );
    }

}