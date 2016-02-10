<?php

namespace OrderEntry\Form;

use Zend\InputFilter\InputFilter;

class CustomerFilter extends InputFilter
{

    public function __construct() {

       $this->add(array(
           'name' => 'first_name',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
           'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100
                    )
                )
            )
       ));
       
       $this->add(array(
           'name' => 'last_name',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
           'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100
                    )
                )
            )
       ));
       
       $this->add(array(
           'name' => 'address',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
       ));
       
       $this->add(array(
           'name' => 'contacts',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
       ));
       
       $this->add(array(
           'name' => 'credit_limit',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
       ));
       
       $this->add(array(
           'name' => 'gender',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
       ));
     
        
        
    }

}