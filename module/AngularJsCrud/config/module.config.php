<?php

return array(
    'router' => array(
        'routes' => array(
            'angular-js-crud' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/angular-js-crud[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'AngularJsCrud\Controller\AngularJsCrud',
                        'action' => 'index',
                        'layout_template' => 'ANGULAR_JS_LAYOUT_TEMPLATE'
                    ),
                ),
            ),
            'angular-js-crud-api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/angular-js-crud-api[/:action[/:id[/:page]]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'AngularJsCrud\Controller\AngularJsCrudApi',
                        'action' => 'index',
                    ),
                ),
            ),
            'angular-js-crud-template' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/angular-js-crud-template[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'AngularJsCrud\Controller\AngularJsCrudTemplate',
                        'action' => 'customers',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'AngularJsCrud\Controller\AngularJsCrud' => 
                'AngularJsCrud\Controller\AngularJsCrudController',
            'AngularJsCrud\Controller\AngularJsCrudApi' => 
                'AngularJsCrud\Controller\AngularJsCrudApiController',
            'AngularJsCrud\Controller\AngularJsCrudTemplate' => 
                'AngularJsCrud\Controller\AngularJsCrudTemplateController',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'ANGULAR_JS_LAYOUT_TEMPLATE' => __DIR__ . '/../view/layout/layout.phtml',
            'ANGULAR_JS_CUSTOMER_FORM_TEMPLATE' => __DIR__ . '/../view/angular-js-crud/angular-js-crud-template/form/customer.phtml',
            'ANGULAR_JS_ORDER_FORM_TEMPLATE' => __DIR__ . '/../view/angular-js-crud/angular-js-crud-template/form/order.phtml',
            'ANGULAR_JS_PRODUCT_FORM_TEMPLATE' => __DIR__ . '/../view/angular-js-crud/angular-js-crud-template/form/product.phtml',
        ),
        'template_path_stack' => array(
            'angular-js-crud' => __DIR__ . '/../view',
        ),
         'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
