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
                'label_attributes' => array(
                    'class' => 'control-label col-md-2'
                )
            ),
            'attributes' => array(
                'id' => 'name',
                'class' => 'form-control',
                'placeholder' => 'Insert you name'
            )
        ));

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array(
                'label' => 'Email',
                'label_attributes' => array(
                    'class' => 'control-label col-md-2'
                )
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
                'label_attributes' => array(
                    'class' => 'control-label col-md-2'
                )
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
                'label_attributes' => array(
                    'class' => 'control-label col-md-2'
                )
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
            'options' => array(
                'label' => 'submit',
                'label_attributes' => array(
                    'class' => 'control-label col-md-2 sr-only'
                )
            ),
            'attributes' => array(
                'class' => 'btn btn-primary',
                'id' => 'submit',
                'value' => 'Register'
            )
        ));
    }

}