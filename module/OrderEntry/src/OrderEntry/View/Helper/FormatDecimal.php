<?php

namespace OrderEntry\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FormatDecimal extends AbstractHelper {

    public function __invoke($num) {
        $num = (float)$num;
        return number_format($num,2,'.','');
    }
    
}