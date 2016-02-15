<?php

namespace BackboneJsBlog\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;

class LoginFilter extends InputFilter {

    public function __construct() {

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'emailAddress',
                    'options' => array(
                        'messages' => array(
                            EmailAddress::INVALID_FORMAT => 'Please provide a valid email address.',
                            EmailAddress::INVALID_HOSTNAME => 'Please provide a valid email address.',
                            Hostname::UNKNOWN_TLD => 'Please provide a valid email address.',
                            Hostname::LOCAL_NAME_NOT_ALLOWED => 'Please provide a valid email address.',
                            Hostname::INVALID_HOSTNAME => 'Please provide a valid email address.',
                            EmailAddress::DOT_ATOM => 'Please provide a valid email address.',
                            EmailAddress::INVALID_FORMAT => 'Please provide a valid email address.',
                            EmailAddress::INVALID_LOCAL_PART => 'Please provide a valid email address.',
                            EmailAddress::QUOTED_STRING => 'Please provide a valid email address.',
                        )
                    )
                ),
                
            )
        ));
        
        $this->add(array(
            'name' => 'security',
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Security token expired. Please refresh the page.',
                        )
                    )
                ),
              
            )
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