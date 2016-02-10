<?php

namespace OrderEntry\Service;

use OrderEntry\Model\CustomerTable;
use OrderEntry\Model\PurchaseTable;

class PurchaseService {
    
    protected $customer;
    protected $purchase;
    
    public function __construct(PurchaseTable $purchaseTable, CustomerTable $customerTable) {
        
        $this->customer = $customerTable;
        $this->purchase = $purchaseTable;
    }
    
    public function getCustomersPurchases() {
        $result = array();
        if($this->customer->getCustomers()) {
            foreach($this->customer->getCustomers() as $k => $customer) {
                $customer->purchases = $this->purchase->getCustomerPurchases($customer->id);

                array_push($result,$customer);
            }
        }
        return $result;
    }
}