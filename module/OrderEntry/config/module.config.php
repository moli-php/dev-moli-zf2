<?php

return array(
    'router' => array(
        'routes' => array(
            'order-entry' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/order-entry[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'OrderEntry\Controller\OrderEntry',
                        'action' => 'index',
                    ),
                ),
            ),
            'order-entry-api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/order-entry-api[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'OrderEntry\Controller\OrderEntryApi',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'OrderEntry\Controller\OrderEntry' => 'OrderEntry\Controller\OrderEntryController',
            'OrderEntry\Controller\OrderEntryApi' => 'OrderEntry\Controller\OrderEntryApiController',
        ),
//        'factories' => array(
//            'OrderEntry\Factory\Controller\OrderEntry' => 'OrderEntry\Factory\Controller\OrderEntryFactory'
//        ),

    ),
    'view_manager' => array(
        'template_map' => array(
            'ORDER_ENTRY_LAYOUT_TEMPLATE' => __DIR__ . '/../view/layout/layout.phtml',
            'order-entry/error/404' => __DIR__ . '/../view/error/404.phtml',
            'order-entry/error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_path_stack' => array(
            'order-entry' => __DIR__ . '/../view',
        ),
        'module_layouts' => array(
            'default' => 'layout/album',
            'order_entry' => 'ORDER_ENTRY_LAYOUT_TEMPLATE'
        )
    ),
);
