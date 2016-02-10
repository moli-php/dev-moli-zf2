<?php

namespace BackboneJsBlog\Form;

use Zend\InputFilter\InputFilter;

class BlogFilter extends InputFilter
{
    public function __construct()
    {
    
        $this->add(array(
            'name' => 'message',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        
        
    
    }
}