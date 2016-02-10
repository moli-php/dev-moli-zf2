<?php

namespace AngularJsCrud\Model;

class Orders {

    public $cust_id;
    public $product_id;
    public $quantity;
    public $date;

    public function exchangeArray($data) {
        $this->cust_id = !empty($data['cust_id']) ? $data['cust_id'] : null;
        $this->product_id = !empty($data['product_id']) ? $data['product_id'] : null;
        $this->quantity = !empty($data['quantity']) ? $data['quantity'] : null;
        $this->date = !empty($data['date']) ? $data['date'] :  date('Y-m-d H:i:s');
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

