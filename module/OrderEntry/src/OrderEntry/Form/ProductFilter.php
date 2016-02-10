<?php

namespace OrderEntry\Form;

use Zend\InputFilter\InputFilter;

class ProductFilter extends InputFilter
{

    public function __construct() {

       $this->add(array(
           'name' => 'product',
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
           'name' => 'price',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
           'validators' => array(
               array(
                   'name' => 'regex',
                   'options' => array(
                       'pattern' => '/^[1-9]+[0-9]*.?[0-9]*/',
                       'message' => 'enter a valid price'
                   ),
                   
               )
           )
          
       ));
       
       $this->add(array(
           'name' => 'type',
           'required' => true,
           'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
           ),
       ));
       
     
        
        
    }

}