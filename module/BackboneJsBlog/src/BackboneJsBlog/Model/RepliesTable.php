<?php

namespace BackboneJsBlog\Model;

use Zend\Db\TableGateway\TableGateway;

class RepliesTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getReplies($id) {

//        $sql = $this->tableGateway->getSql();

        $select = $this->tableGateway->getSql()->select();
        $select->join(
                array('u' => 'backbone_blog_users'), 
                'backbone_blog_replies.user_id = u.id',
                array('name','username'),
                "left"
                );
        $select->where(array('forum_id' => $id));
        
        $resultSet = $this->tableGateway->selectWith($select);

//        echo $sql->getSqlstringForSqlObject($select); die ; 
        return $resultSet;
    }
    

    
    public function saveReply($data) {
        
         $aData = array(
            'forum_id' => $data->forum_id,
            'user_id' => $data->user_id,
            'message' => $data->message,
            'date' => $data->date
        );

        $this->tableGateway->insert($aData);
        return $this->tableGateway->getLastInsertValue();
        
    }
    
      public function deleteReply($id) {
        
        return $this->tableGateway->delete(array('id' => $id));
        
    }

}

