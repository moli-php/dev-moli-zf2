<?php

namespace OrderEntry\Model;

class Purchase {
    
    public $id;
    public $cust_id;
    public $product_id;
    public $quantity;
    public $price;
    public $amount;
    public $status;
    public $date;
    
    public function exchangeArray($data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->cust_id = !empty($data['cust_id']) ? $data['cust_id'] : null;
        $this->product_id = !empty($data['product_id']) ? $data['product_id'] : null;
        $this->quantity = !empty($data['quantity']) ? $data['quantity'] : null;
        $this->price = !empty($data['price']) ? $data['price'] : null;
        $this->amount = !empty($data['amount']) ? $data['amount'] : null;
        $this->status = !empty($data['status']) ? $data['status'] : 0;
        $this->date = !empty($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}