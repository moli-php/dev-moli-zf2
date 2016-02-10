<?php

namespace OrderEntry\Model;

class Customer {
    
    public $id;
    public $first_name;
    public $last_name;
    public $gender;
    public $contacts;
    public $address;
    public $credit_limit;
    public $date;
    
    public function exchangeArray($data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->gender = !empty($data['gender']) ? $data['gender'] : null;
        $this->contacts = !empty($data['contacts']) ? $data['contacts'] : null;
        $this->address = !empty($data['address']) ? $data['address'] : null;
        $this->credit_limit = !empty($data['credit_limit']) ? $data['credit_limit'] : null;
        $this->date = !empty($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}