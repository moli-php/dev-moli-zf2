<?php

return array(
    'router' => array(
        'routes' => array(
            'calendar-scheduler' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/calendar-scheduler[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'CalendarScheduler\Controller\CalendarScheduler',
                        'action' => 'index',
                        'layout_template' => 'CALENDAR_SCHEDULER_LAYOUT_TEMPLATE'
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CalendarScheduler\Controller\CalendarScheduler' => 
                'CalendarScheduler\Controller\CalendarSchedulerController',
        ),

    ),
    'view_manager' => array(
        'template_map' => array(
            'CALENDAR_SCHEDULER_LAYOUT_TEMPLATE' => __DIR__ . '/../view/layout/layout.phtml',
            'CALENDAR_SCHEDULER_FORM' => __DIR__ . '/../view/calendar-scheduler/calendar-scheduler/helper/form.phtml',
        ),
        'template_path_stack' => array(
            'calendar-scheduler' => __DIR__ . '/../view',
        ),
         'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);