<?php
namespace BackboneJsBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\StdLib\Hydrator\ClassMethods;
use BackboneJsBlog\Form\LoginFilter;



class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('blog_login');
        
        $this->setAttributes(array('method'=>'post', 'class' => 'form form-horizontal','role' => 'form'));
        $this->setInputFilter(new LoginFilter());
        
        $this->add(new Element\Csrf('security'));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Insert you email'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'id' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Insert your password'
            )
        ));
        
      
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'class' => 'btn btn-primary pull-right',
                'id' => 'submit',
                'value' => 'Login'
            )
        ));
    }
}