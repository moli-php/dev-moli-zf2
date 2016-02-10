<?php

namespace AngularJsCrud\Model;

class Customers {

    public $id;
    public $first_name;
    public $last_name;
    public $address;
    public $contact_no;
    public $email;
    public $date;

    public function exchangeArray($data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->address = !empty($data['address']) ? $data['address'] : null;
        $this->contact_no = !empty($data['contact_no']) ? $data['contact_no'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->date = !empty($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

