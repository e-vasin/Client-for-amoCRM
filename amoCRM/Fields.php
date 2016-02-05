<?php

namespace amoCRM;

/**
 * @method amoCRM\Fields add(Field $field) Description
 */

class Fields extends Collection {
    
    /**
     * 
     * @return \amoCRM\Field
     */
    public function createField($id) {
        $field = new Field();
        $field->setId($id);
        $this->add($field);
        return $field;
    }


    public function fromArray(array $array, $type) {
        if (is_null($array)) {
            return $this;
        }
        foreach ($array as $array) {
            $array['element_type'] = $type;
            $this->add(Field::createFromArray($array));
        }
        return $this;
    }
    
    public static function createFromArray(array $array) {
        $fields = new self;
        $fields->fromArray($array);
        return $fields;
    }
    
    public function toArray() {
        $array = [];
        foreach ($this->elements as $entity) {
            $array[] = $entity->toArray();
        }
        return $array;
    }
    
}