<?php

namespace amoCRM;

class Account extends \amoCRM {
    
    public function getResponse() {
        return parent::getResponse('accounts/current');
    }
    
}