<?php
namespace BackboneJsBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class SearchForm extends Form
{
    public function __construct()
    {
        parent::__construct('blog');
        
        $this->setAttributes(array('method'=>'post', 'class' => 'form-inline col-md-4 pull-right','role' => 'form'));
        $this->setInputFilter(new BlogFilter());
        
        
        $this->add(array(
            'name' => 'blog_search',
            'type' => 'text',

            'attributes' => array(
                'id' => 'blog_search',
                'class' => 'form-control',
                'placeholder' => 'Blog Search'
            )
        ));
        
      
    }
}