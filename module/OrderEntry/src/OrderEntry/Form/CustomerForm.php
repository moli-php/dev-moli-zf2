<?php

namespace OrderEntry\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use OrderEntry\Form\CustomerFilter;

class CustomerForm extends Form {

    public function __construct() {

        parent::__construct('customer_form');

        $this->setAttributes(array('method' => 'post', 'class' => 'form form-horizontal', 'role' => 'form'));
        $this->setInputFilter(new CustomerFilter());

        $this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'first_name',
            'type' => 'text',
            'options' => array(
                'label' => 'First name :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'first_name',
                'class' => 'form-control',
                'placeholder' => 'Insert first name',
            )
        ));

        $this->add(array(
            'name' => 'last_name',
            'type' => 'text',
            'options' => array(
                'label' => 'Last name :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'last_name',
                'placeholder' => 'Insert last name',
            )
        ));

        $this->add(array(
            'name' => 'address',
            'type' => 'text',
            'options' => array(
                'label' => 'Address :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'address',
                'class' => 'form-control',
                'placeholder' => 'Insert address',
            )
        ));

        $this->add(array(
            'name' => 'contacts',
            'type' => 'text',
            'options' => array(
                'label' => 'Contact No. :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'contacts',
                'class' => 'form-control',
                'placeholder' => 'Insert contact number',
            )
        ));

        $this->add(array(
            'name' => 'credit_limit',
            'type' => 'select',
            'options' => array(
                'value_options' => array(
                    '10000' => 10000, 
                    '20000' => 20000,
                    '50000' => 50000,
                    '100000' => 100000,
                    '500000' => 500000,
                    '0' => 'Unlimited'
                    ),
                'label' => 'Credit limit :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'credit_limit',
            )
        ));

        $this->add(array(
            'name' => 'gender',
            'type' => 'Radio',
            'options' => array(
                'label' => 'Credit limit :',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'value_options' => array(
                    'male' => array(
                        'label' => 'Male',
                        'value' => 'male',
                        'attributes' => array(
                            'id' => "male",
                        ),
                        'label_attributes' => array(
                            'class' => 'radio-inline',
                        )
                    ),
                    'female' => array(
                        'label' => 'Female',
                        'value' => 'female',
                        'attributes' => array(
                            'id' => "female",
                        ),
                        'label_attributes' => array(
                            'class' => 'radio-inline',
                        )
                    ),
                ),
            ),
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