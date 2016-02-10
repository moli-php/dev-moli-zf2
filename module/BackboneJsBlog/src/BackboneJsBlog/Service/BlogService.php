<?php

namespace BackboneJsBlog\Service;

class BlogService {
    
    protected $blogTable;
    protected $repliesTable;
    
    public function __construct($blogTable, $repliesTable) {
        $this->blogTable = $blogTable;
        $this->repliesTable = $repliesTable;
    }
    
   public function getBlog() {
       $getBlog = $this->blogTable->getBlog();
       $data = array();
       if(count($getBlog)){
           foreach($getBlog as $k => $v) {
              $replies = $this->repliesTable->getReplies($v->id);
             
              if(count($replies)){
                  foreach($replies as $reply){
                      $v->replies[] = $reply;
                  }
              }
              $data[$k] = $v;
           }
       }
       return $data;
   }
            
    
}
