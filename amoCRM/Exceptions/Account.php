<?php

namespace amoCRM\Exceptions;

class Account extends \amoCRM\Exception {
    public function __construct($code, \Exception $previous = NULL) {
        $this->code+= [
            101 => 'Аккаунт не найден',
            102 => 'POST-параметры должны передаваться в формате JSON',
            103 => 'Параметры не переданы',
            104 => 'Запрашиваемый метод API не найден'
        ];
        parent::__construct($code, $previous);
    }
}