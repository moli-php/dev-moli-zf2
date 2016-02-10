<?php

namespace CalendarScheduler\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class CalendarForm extends Form {

    public function __construct() {

        parent::__construct('customer_form');

        $this->setAttributes(array('method' => 'post', 'class' => 'form form-horizontal', 'role' => 'form'));
        $this->setAttributes(array('options' => array('id' => 'calendar_form')));
        $this->add(new Element\Csrf('security'));

        $this->add(array(
            'name' => 'event',
            'type' => 'text',
            'options' => array(
                'label' => 'Event',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'event',
                'class' => 'form-control',
                'placeholder' => 'Enter Event',
            )
        ));

        $this->add(array(
            'name' => 'from',
            'type' => 'text',
            'options' => array(
                'label' => 'From',
                'label_attributes' => array(
                    'class' => 'col-sm-4 control-label',
                )
            ),
            'attributes' => array(
                'class' => 'form-control time_field',
                'id' => 'from',
                'placeholder' => 'Enter from time',
            )
        ));

        $this->add(array(
            'name' => 'to',
            'type' => 'text',
            'options' => array(
                'label' => 'To',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'to',
                'class' => 'form-control time_field to_responsive_width',
                'placeholder' => 'Enter to time',
            )
        ));

        $this->add(array(
            'name' => 'location',
            'type' => 'text',
            'options' => array(
                'label' => 'Location',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                )
            ),
            'attributes' => array(
                'id' => 'location',
                'class' => 'form-control',
                'placeholder' => 'Enter location',
            )
        ));


        $this->add(array(
            'type' => 'button',
            'name' => 'btn_add',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'id' => 'btn_add',
                'disabled' => true,
            ),
            'options' => array(
                'label' => '<i class="glyphicon glyphicon-plus"></i> Add',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label sr-only'
                ),
                'label_options' => array(
                    'disable_html_escape' => true
                )
            ),
        ));

        $this->add(array(
            'type' => 'button',
            'name' => 'btn_update',
            'attributes' => array(
                'class' => 'btn btn-warning',
                'id' => 'btn_update',
                'style' => 'display:none;'
            ),
            'options' => array(
                'label' => '<i class="glyphicon glyphicon-pencil"></i> Update',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label sr-only'
                ),
                 'label_options' => array(
                    'disable_html_escape' => true
                )
            ),
        ));

        $this->add(array(
            'type' => 'button',
            'name' => 'btn_delete',
            'attributes' => array(
                'class' => 'btn btn-danger',
                'id' => 'btn_delete',
                'style' => 'display:none;'
            ),
            'options' => array(
                'label' => '<i class="glyphicon glyphicon-trash"></i> Delete',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label sr-only'
                ),
                 'label_options' => array(
                    'disable_html_escape' => true
                )
            ),
        ));

        $this->add(array(
            'type' => 'button',
            'name' => 'btn_cancel',
            'attributes' => array(
                'class' => 'btn',
                'id' => 'btn_cancel',
                'style' => 'display:none;'
            ),
            'options' => array(
                'label' => '<i class="glyphicon glyphicon-remove"></i> Cancel',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label sr-only'
                ),
                 'label_options' => array(
                    'disable_html_escape' => true
                )
            ),
        ));

        $this->add(array(
            'type' => 'hidden',
            'name' => 'hidden_id',
            'attributes' => array(
                 'id' => 'hidden_id',
                'value' => ''
            )
        ));

        $this->add(array(
            'type' => 'hidden',
            'name' => 'hidden_selected_date',
            'attributes' => array(
                'id' => 'hidden_selected_date',
                'value' => ''
            )
        ));
    }

}