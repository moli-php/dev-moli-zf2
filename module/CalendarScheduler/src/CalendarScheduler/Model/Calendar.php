<?php

namespace CalendarScheduler\Model;

class Calendar {

    public $id;
    public $event;
    public $from_time;
    public $to_time;
    public $location;
    public $date;

    public function exchangeArray($data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->event = !empty($data['event']) ? $data['event'] : null;
        $this->location = !empty($data['location']) ? $data['location'] : null;
        $this->from_time = !empty($data['from_time']) ? $data['from_time'] : null;
        $this->to_time = !empty($data['to_time']) ? $data['to_time'] : null;
        $this->date = !empty($data['date']) ? $data['date'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}

