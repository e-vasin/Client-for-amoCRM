<?php

namespace amoCRM;

/**
 * @property-read string $name Название поля
 * @property-read string $code Код поля. Установлен только у предустановленных полей
 * @property-read integer $type Тип поля
 * @property-read integer $elementType Сущность
 * @property-read string $origin Уникальный идентификатор сервиса по которому будет доступно удаление и изменение поля
 * @property-read Values $values Значения поля
 * 
 * @method \amoCRM\Field setId(integer $id)
 */
class Field extends Element {

    const CONTACT = 1;
    const LEAD = 2;
    const COMPANY = 3;
    
    const TEXT = 1;
    const NUMERIC = 2;
    const CHECKBOX = 3;
    const SELECT = 4;
    const MULTISELECT = 5;
    const DATE = 6;
    const URL = 7;
    const MULTITEXT = 8;
    const TEXTAREA = 9;
    const RADIOBUTTON = 10;
    const STREETADDRESS = 11;
    const SMARTADDRESS = 12;
    const BIRTHDAY = 13;

    protected $name;
    protected $enum;
    protected $code;
    protected $type;
    protected $elementType;
    protected $origin;
    protected $values;

    public function __construct() {
        $this->values = new Values();
    }

    /**
     * 
     * @param string $name
     * @return \amoCRM\Field
     */
    public function setName($name) {
        $this->name = (string) $name;
        return $this;
    }
    
    public function setEnum($enum) {
        $this->enum = (string) $enum;
        return $this;
    }

    /**
     * 
     * @param string $code
     * @return \amoCRM\Field
     */
    public function setCode($code) {
        $this->code = (string) $code;
        return $this;
    }

    /**
     * 
     * @param integer $type
     * @return \amoCRM\Field
     */
    public function setType($type) {
        $this->type = (integer) $type;
        return $this;
    }

    /**
     * 
     * @param integer $type
     * @return \amoCRM\Field
     * @throws Exception
     */
    public function setElementType($type) {
        $this->elementType = (integer) $type;
        return $this;
    }

    /**
     * 
     * @param string $origin
     * @return \amoCRM\Field
     */
    public function setOrigin($origin) {
        $this->origin = (string) $origin;
        return $this;
    }
    
    public function setValues(Values $values) {
        $this->values = $values;
    }

    public function fromArray(array $array) {
        $this->setId((int) $array['id']);
        $this->setName($array['name']);
        $this->setCode($array['code']);
        $this->setElementType($array['element_type']);
        $this->values->fromArray($array['values']);
        return $this;
    }

    public static function createFromArray(array $array) {
        $field = new self($array['name']);
        $field->fromArray($array);
        return $field;
    }

    public function toArray() {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'values' => $this->values->toArray()
        ];
        return array_filter($array, function($item) {
            return !is_null($item);
        });
    }
    
    /**
     * 
     * @param mixed $value
     * @param string $enum
     * @return \amoCRM\Field
     */
    public function addValue($value, $enum = NULL) {
        $this->values->addValue($value, $enum);
        return $this;
    }

}
