<?php

return array(
    'router' => array(
        'routes' => array(
            'web-designs' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/web-designs[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'WebDesigns\Controller\WebDesigns',
                        'action' => 'design-one',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'WebDesigns\Controller\WebDesigns' => 'WebDesigns\Controller\WebDesignsController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'web-designs' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'DESIGN_ONE_LAYOUT' => __DIR__ . '/../view/layout/layout-one.phtml',
            'DESIGN_TWO_LAYOUT' => __DIR__ . '/../view/layout/layout-two.phtml',
            'DESIGN_THREE_LAYOUT' => __DIR__ . '/../view/layout/layout-three.phtml',
            'DESIGN_FOUR_LAYOUT' => __DIR__ . '/../view/layout/layout-four.phtml',
            'DESIGN_FIVE_LAYOUT' => __DIR__ . '/../view/layout/layout-five.phtml',
        )
    ),
);
