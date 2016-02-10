<?php

namespace OrderEntry\Model;

class Payments {
    
    public $id;
    public $cust_id;
    public $purchase_id;
    public $amount;
    public $date;
    
    public function exchangeArray($data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->cust_id = !empty($data['cust_id']) ? $data['cust_id'] : null;
        $this->purchase_id = !empty($data['purchase_id']) ? $data['purchase_id'] : null;
        $this->amount = !empty($data['amount']) ? $data['amount'] : null;
        $this->date = !empty($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
    }
    
     public function getArrayCopy() {
        return get_object_vars($this);
    }
}