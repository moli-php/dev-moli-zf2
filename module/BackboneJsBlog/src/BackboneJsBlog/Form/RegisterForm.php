<?php

namespace BackboneJsBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\StdLib\Hydrator\ClassMethods;
use BackboneJsBlog\Form\RegisterFilter;

class RegisterForm extends Form {

    public function __construct() {
        parent::__construct('blog_register');

        $this->setAttributes(array('method' => 'post', 'class' => 'form form-horizontal', 'role' => 'form'));
        $this->setInputFilter(new RegisterFilter());

        $this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'id' => 'nae',
                'class' => 'form-control',
                'placeholder' => 'Insert you name'
            )
        ));

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'id' => 'username',
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
            'name' => 'confirm_password',
            'type' => 'password',
            'options' => array(
                'label' => 'Re-enter password',
            ),
            'attributes' => array(
                'id' => 'password2',
                'class' => 'form-control',
                'placeholder' => 'Re-enter your password'
            )
        ));



        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'class' => 'btn btn-primary pull-right',
                'id' => 'submit',
                'value' => 'Register'
            )
        ));
    }

}