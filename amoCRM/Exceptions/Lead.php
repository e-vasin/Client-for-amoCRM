<?php

namespace amoCRM\Exceptions;

class Contact extends \amoCRM\Exception {
    public function __construct($code, \Exception $previous = NULL) {
        $this->code+= [
            213 => 'Добавление сделок: пустой массив',
            214 => 'Добавление/Обновление сделок: пустой запрос',
            215 => 'Добавление/Обновление сделок: неверный запрашиваемый метод',
            216 => 'Обновление сделок: пустой массив',
            217 => 'Обновление сделок: требуются параметры "id", "last_modified", "status_id", "name"',
            240 => 'Добавление/Обновление сделок: неверный параметр "id" дополнительного поля'
        ];
        parent::__construct($code, $previous);
    }
}