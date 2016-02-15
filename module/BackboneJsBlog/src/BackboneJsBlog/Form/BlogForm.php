<?php
namespace BackboneJsBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\StdLib\Hydrator\ClassMethods;
use BackboneJsBlog\Form\BlogFilter;



class BlogForm extends Form
{
    public function __construct()
    {
        parent::__construct('blog');
        
        $this->setAttributes(array('method'=>'post', 'class' => 'form form-inline','role' => 'form'));
        $this->setInputFilter(new BlogFilter());
        
        
        $this->add(array(
            'name' => 'message',
            'type' => 'text',
            'options' => array(
                'label' => 'Message',
                'label_attributes' => array(
                    'class' => 'control-label col-md-2'
                )
            ),
            'attributes' => array(
                'id' => 'message',
                'class' => 'form-control',
                'placeholder' => 'Insert your message here'
            )
        ));
        
        $this->add(array(
            'name' => 'user_id',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'user_id'
            )
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'hidden',
             'attributes' => array(
                'id' => 'name'
            )
        ));
        
        $this->add(array(
            'name' => 'username',
            'type' => 'hidden',
             'attributes' => array(
                'id' => 'username'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'id' => 'submit',
                'value' => 'Submit'
            )
        ));
    }
}