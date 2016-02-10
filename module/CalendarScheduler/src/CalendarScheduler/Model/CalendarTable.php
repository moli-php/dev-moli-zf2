<?php

namespace CalendarScheduler\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;

class CalendarTable {
    
    
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getCalendar() {
        return $this->tableGateway->select();
    }
    
    public function getByDateCalendar($data) {
        $select = $this->tableGateway->getSql()->select();
        $select->where(array('date' => $data['search']))
                ->order(array('from_time ASC'));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
        
    }
    
    public function addCalendar($data) {
        
      return $this->tableGateway->insert($data);
        
    }
    
    public function deleteCalendar($id) {
        return $this->tableGateway->delete(array('id' => $id));
    }
    
    public function updateCalendar($id, $data) {
        return $this->tableGateway->update($data, array('id' => $id));
    }
    
    
    
    
}