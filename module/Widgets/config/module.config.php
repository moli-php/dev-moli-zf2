<?php

return array(
    'router' => array(
        'routes' => array(
            'widgets' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/widgets[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Widgets\Controller\Widgets',
                        'action' => 'youtube',
                    ),
                ),
            ),
            'widgets-api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/widgets-api[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*[a-zA-Z]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Widgets\Controller\WidgetsApi',
                        'action' => 'bbc-news',
                    ),
                ),
            ),
            'widgets-template' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/widgets-template[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*[a-zA-Z]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Widgets\Controller\WidgetsTemplate',
                        'action' => 'youtube-item',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Widgets\Controller\Widgets' => 'Widgets\Controller\WidgetsController',
            'Widgets\Controller\WidgetsApi' => 'Widgets\Controller\WidgetsApiController',
            'Widgets\Controller\WidgetsTemplate' => 'Widgets\Controller\WidgetsTemplateController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'widgets' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'YOUTUBE_LAYOUT_TEMPLATE' => __DIR__ . '/../view/layout/youtube-layout.phtml',
            'YOUTUBE_IFRAME_ITEM' => __DIR__ . '/../view/widgets/widgets/template/youtube-item.phtml',
            'BBC_NEWS_ITEM' => __DIR__ . '/../view/widgets/widgets/template/bbc-news-item.phtml',
            'ANALOG_CLOCK_LAYOUT_TEMPLATE' => __DIR__ . '/../view/layout/analog-clock-layout.phtml',
            'BBC_NEWS_LAYOUT_TEMPLATE' => __DIR__ . '/../view/layout/bbc-news-layout.phtml',
        )
    ),
);
