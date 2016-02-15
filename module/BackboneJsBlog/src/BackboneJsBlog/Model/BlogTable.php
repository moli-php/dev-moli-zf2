<?php

namespace BackboneJsBlog\Model;

use Zend\Db\TableGateway\TableGateway;

class BlogTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getBlog() {
        
//        $sql = $this->tableGateway->getSql();
        
        $select = $this->tableGateway->getSql()->select();
        $select->join(
                    array('u' => 'backbone_blog_users'), 
                    'backbone_blog.user_id = u.id', 
                    array('name','username')
                );
        
        $resultSet = $this->tableGateway->selectWith($select);

//        echo $sql->getSqlstringForSqlObject($select); die ; 
        return $resultSet;
    }
    
    public function saveBlog($data) {
        $aData = array(
            'user_id' => $data->user_id,
            'message' => $data->message
        );
        $this->tableGateway->insert($aData);
        return $this->tableGateway->getLastInsertValue();
    }
    
    public function deleteBlog($id) {
        
        return $this->tableGateway->delete(array('id' => $id));
        
    }
    
    

}

