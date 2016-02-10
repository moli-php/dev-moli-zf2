<?php

namespace BackboneJsBlog\Model;

class Users {
    
    public $id;
    public $name;
    public $username;
    public $password;
    public $date;
    
    public function exchangeArray($data) {
        
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->username = !empty($data['username']) ? $data['username'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->date = !empty($data['date']) ? $data['date'] : null;
       
    }
    
     public function getArrayCopy() {
        return get_object_vars($this);
    }
}