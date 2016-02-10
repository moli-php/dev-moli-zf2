<?php

namespace OrderEntry\Model;

class Product {
    
    public $id;
    public $product;
    public $price;
    public $type;
    public $date;
    
    public function exchangeArray($data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->product = !empty($data['product']) ? $data['product'] : null;
        $this->price = !empty($data['price']) ? $data['price'] : null;
        $this->type = !empty($data['type']) ? $data['type'] : null;
        $this->date = !empty($data['date']) ? $data['date'] : date('Y-m-d H:i:s');
    }
    
     public function getArrayCopy() {
        return get_object_vars($this);
    }
}