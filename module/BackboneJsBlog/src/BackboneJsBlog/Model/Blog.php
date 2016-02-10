<?php

namespace BackboneJsBlog\Model;

class Blog {
    
    public $id;
    public $user_id;
    public $message;
    public $date;

    
    public function exchangeArray($data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->user_id = !empty($data['user_id']) ? $data['user_id'] : null;
        $this->message = !empty($data['message']) ? $data['message'] : null;
        $this->date = !empty($data['date']) ? $data['date'] : null;
        
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}