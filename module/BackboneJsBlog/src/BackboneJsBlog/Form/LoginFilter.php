<?php

namespace BackboneJsBlog\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
    
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),

        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),

        ));

        
        
    
    }
}