<?php

namespace amoCRM;

/**
 * @property-read integer $length
 */
class Collection extends \amoCRM implements \Iterator {

    const ADD = 'add';
    const UPDATE = 'update';
    
    protected $elements = [];

    public function add(Element $element) {
        $this->elements[$element->id] = $element;
        $element->setCollection($this);
        return $this;
    }

    /**
     * 
     * @param integer $id
     * @return Element
     * @throws \Exception
     */
    public function item($id) {
        if (!isset($this->elements[$id])) {
            throw new \Exception('Элемент id=' . $id . ' не найден в коллекции ' . get_class($this));
        }
        return $this->elements[$id];
    }

    public function rewind() {
        return reset($this->elements);
    }

    public function key() {
        return key($this->elements);
    }

    public function next() {
        return next($this->elements);
    }

    public function current() {
        return current($this->elements);
    }

    public function valid() {
        $key = key($this->elements);
        return (!is_null($key) && $key !== FALSE);
    }

    public function __get($name) {
        switch ($name) {
            case 'length':
                return count($this->elements);
        }
    }

}
