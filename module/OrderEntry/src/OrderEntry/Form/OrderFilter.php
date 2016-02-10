<?php

namespace OrderEntry\Form;

use Zend\InputFilter\InputFilter;

class OrderFilter extends InputFilter
{

    public function __construct() {

       $this->add(array(
           'name' => 'cust_id',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),

       ));
       
       $this->add(array(
           'name' => 'product_id',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
          
       ));
       
       $this->add(array(
           'name' => 'quantity',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
           'validators' => array(
               array(
                    'name' => 'digits',
                )
           )
       ));
       
     
        
        
    }

}