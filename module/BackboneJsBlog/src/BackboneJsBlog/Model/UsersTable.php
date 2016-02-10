<?php

namespace BackboneJsBlog\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }


    public function getUsername($username) {
         $resultSet = $this->tableGateway->select(array(
            "username"  => strtolower($username)
        ));
        return $resultSet->count();
    }

    public function saveUser($data) {
        $aData = array(
            'name' => $data->name,
            'username' => strtolower($data->username),
            'password' => md5($data->password)
        );
        return $this->tableGateway->insert($aData);
    }

}

