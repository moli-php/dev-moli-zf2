<?php

namespace OrderEntry\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use OrderEntry\Form\OrderFilter;

class OrderForm extends Form {

    public function __construct() {

        parent::__construct('order');

        $this->setAttributes(array('method' => 'post', 'class' => 'form form-horizontal', 'role' => 'form'));
        $this->setInputFilter(new OrderFilter());

        $this->add(new Element\Csrf('security'));

      

        $this->add(array(
            'name' => 'cust_id',
            'type' => 'select',
            'options' => array(
                'label' => 'Customer :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cust_id',
            )
        ));
        
        $this->add(array(
            'name' => 'product_id',
            'type' => 'select',
            'options' => array(
                'label' => 'Product :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cust_id',
            )
        ));
        
        $this->add(array(
            'name' => 'quantity',
            'type' => 'select',
            'options' => array(
                'value_options' => array(1,2,3,4,5,6,7,8,9,10,'Custom'),
                'label' => 'Quantity :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'cust_id',
            )
        ));

     
        $this->add(array(
            'type' => 'submit',
            'name' => 'button',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'id' => 'btn_add',
            ),
            'options' => array(
                'label' => 'Add',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label sr-only'
                ),
  
            ),
        ));
    }

}