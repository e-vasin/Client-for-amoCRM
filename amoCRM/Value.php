<?php

namespace amoCRM;

/**
 * @property-read string $value Значение дополнительного поля
 * @property-read string $enum Выбираемый тип дополнительного поля (напр телефон домашний, рабочий и т д)
 */
class Value extends Element {

    protected $value;
    protected $enum;
    
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
    public function setEnum($enum) {
        $this->enum = (string) $enum;
        return $this;
    }
    
    public function fromArray(array $array) {
        $this->setValue($array['value']);
        $this->setEnum($array['enum']);
        return $this;
    }

    public static function createFromArray($array) {
        $value = new self($array['value']);
        $value->fromArray($array);
        return $value;
    }

    public function toArray() {
        $array = [
            'value' => $this->value,
            'enum' => $this->enum
        ];
        return array_filter($array, function($item) {
            return !is_null($item);
        });
    }

}
