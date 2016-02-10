<?php

return array(
    'router' => array(
        'routes' => array(
            'animal-quiz' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/animal-quiz[/:action[/:id]]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        'controller' => 'AnimalQuiz\Controller\AnimalQuiz',
                        'action' => 'index',
                        'layout_template' => 'ANIMAL_QUIZ_TEMPLATE'
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'AnimalQuiz\Controller\AnimalQuiz' => 'AnimalQuiz\Controller\AnimalQuizController'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'ANIMAL_QUIZ_TEMPLATE' => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            'animal-quiz' => __DIR__ . '/../view',
        ),
         'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
