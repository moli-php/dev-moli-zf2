<?php

namespace OrderEntry\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use OrderEntry\Form\ProductFilter;

class ProductForm extends Form {

    public function __construct() {

        parent::__construct('product_form');

        $this->setAttributes(array('method' => 'post', 'class' => 'form form-horizontal', 'role' => 'form'));
        $this->setInputFilter(new ProductFilter());

        $this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'product',
            'type' => 'text',
            'options' => array(
                'label' => 'Product :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'product',
                'class' => 'form-control',
                'placeholder' => 'Insert product',
            )
        ));

        $this->add(array(
            'name' => 'price',
            'type' => 'text',
            'options' => array(
                'label' => 'Price :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'price',
                'placeholder' => 'Insert price',
            )
        ));

        $this->add(array(
            'name' => 'type',
            'type' => 'text',
            'options' => array(
                'label' => 'Type :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'type',
                'class' => 'form-control',
                'placeholder' => 'Insert type',
            )
        ));

     
         $this->add(array(
            'type' => 'button',
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