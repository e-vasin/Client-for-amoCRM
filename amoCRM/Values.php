<?php

namespace amoCRM;

class Values extends Collection {

    public function createValue($val, $enum = NULL) {
        $value = new Value();
        $value->setValue($val);
        if ($enum) {
            $value->setEnum($enum);
        }
        $this->add($value);
        return $value;
    }
    
    public function addValue($value, $enum = NULL) {
        $this->createValue($value, $enum);
        return $this;
    }

    public function add(Value $value) {
        $this->elements[] = $value;
        $value->setCollection($this);
        return $this;
    }

    public function fromArray(array $array) {
        foreach ($array as $array) {
            $this->add(Value::createFromArray($array));
        }
        return $this;
    }

    public static function createFromArray($array) {
        $values = new self;
        $values->fromArray($array);
        return $values;
    }

    public function toArray() {
        $array = [];
        foreach ($this->elements as $entity) {
            $array[] = $entity->toArray();
        }
        return $array;
    }

}
