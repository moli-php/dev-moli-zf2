<?php

return array(
    
    'router' => array(
        'routes' => array(
            'backbone-js-blog' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/backbone-js-blog[/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'BackboneJsBlog\Controller\Blog',
                        'action' => 'index',
                    ),
                ),
            ),
            'backbone-js-blog-api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/backbone-js-blog-api[/:action[/:id]][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'BackboneJsBlog\Controller\BlogApi',
                        'action' => 'api',
                    ),
                ),
            ),
            'backbone-js-blog-register-login' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/backbone-js-blog-register-login[/:action[/:id]][/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'BackboneJsBlog\Controller\RegisterLogin',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'BackboneJsBlog\Controller\Blog' => 'BackboneJsBlog\Controller\BlogController',
            'BackboneJsBlog\Controller\BlogApi' => 'BackboneJsBlog\Controller\BlogApiController',
            'BackboneJsBlog\Controller\RegisterLogin' => 'BackboneJsBlog\Controller\RegisterLoginController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'backbone-js-blog' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'BACKBONE_JS_BLOG_LAYOUT_TEMPLATE' => __DIR__ . '/../view/layout/layout.phtml',
        ),
         'strategies' => array(
            'ViewJsonStrategy',
        ),
    )
);