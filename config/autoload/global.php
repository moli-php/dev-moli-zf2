<?php

return array(
    'db' => array(
        'adapters' => array(
            'site_db' => array(
                'driver' => 'Pdo',
                'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''),
            )
        )
    ),
   'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
);
