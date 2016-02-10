<?php

namespace OrderEntry\Service;

use OrderEntry\Model\CustomerTable;
use OrderEntry\Model\PaymentsTable;

class PaymentService {
    
    protected $customer;
    protected $payment;
    
    public function __construct(PaymentsTable $paymentTable, CustomerTable $customerTable) {
        
        $this->customer = $customerTable;
        $this->payment = $paymentTable;
    }
    
    public function getCustomersPayments() {
        $result = array();
        if($this->customer->getCustomers()) {
            foreach($this->customer->getCustomers() as $k => $customer) {
                $customer->payments = $this->payment->getCustomerPayments($customer->id);

                array_push($result,$customer);
            }
        }
        return $result;
    }
}