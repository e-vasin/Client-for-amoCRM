<?php

namespace amoCRM;

/**
 * @property-read integer $id Уникальный идентификатор сделки, который указывается с целью её обновления
 * @property-read string $name Название сделки
 * @property-read \DateTime $dateCreate Дата создания текущей сделки (не обязательный параметр)
 * @property-read \DateTime $lastModified Дата изменения текущей сделки (не обязательный параметр)
 * @property-read integer $statusId Статус сделки
 * @property-read numeric $price Бюджет сделки
 * @property-read integer $responsibleUserId Уникальный идентификатор ответственного пользователя
 * @property-read Fields $fields Дополнительные поля контакта
 * @property-read array $tags Массив тегов
 */
class Lead extends Element {

    protected $id = NULL;
    protected $name;
    protected $dateCreate = NULL;
    protected $lastModified = NULL;
    protected $statusId;
    protected $price;
    protected $responsibleUserId = NULL;
    protected $fields;
    protected $tags = NULL;

    public function __construct() {
        $this->fields = new Fields();
        $this->dateCreate = new \DateTime();
        $this->lastModified = new \DateTime();
        return $this;
    }

    /**
     * 
     * @param string $value
     * @return \amoCRM\Lead
     */
    public function setName($value) {
        $this->name = (string) $value;
        return $this;
    }

    /**
     * 
     * @param \DateTime $dateCreate
     * @return \amoCRM\Lead
     */
    public function setDateCreate(\DateTime $dateCreate) {
        $this->dateCreate = $dateCreate;
        return $this;
    }

    /**
     * 
     * @param \DateTime $lastModified
     * @return \amoCRM\Lead
     */
    public function setLastModified(\DateTime $lastModified) {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * 
     * @param integer $id
     * @return \amoCRM\Lead
     */
    public function setStatusId($id) {
        $this->statusId = (int) $id;
        return $this;
    }

    /**
     * 
     * @param numeric $price
     * @return \amoCRM\Lead
     */
    public function setPrice($price) {
        $this->price = (float) $price;
        return $this;
    }

    /**
     * 
     * @param integrt $id
     * @return \amoCRM\Lead
     */
    public function setResponsibleUserId($id) {
        $this->responsibleUserId = (int) $id;
        return $this;
    }

    /**
     * 
     * @param \amoCRM\Fields $fields
     * @return \amoCRM\Lead
     */
    public function setFields(Fields $fields) {
        $this->fields = $fields;
        return $this;
    }

    /**
     * 
     * @param type $arrayTags
     * @return \amoCRM\Lead
     */
    public function setTags(array $arrayTags) {
        $this->tags = $arrayTags;
        return $this;
    }

    /**
     * 
     * @param array $array
     * @return \amoCRM\Lead
     * @throws Exception
     */
    public function fromArray(array $array) {
        $this->setId((int) $array['id']);
        $this->setName($array['name']);
        $Date = new \DateTime();
        $this->setLastModified($Date->setTimestamp($array['last_modified']));
        $this->setDateCreate($Date->setTimestamp($array['date_create']));
        $this->setStatusId((int) $array['status_id']);
        $this->setPrice($array['price']);
        $this->setResponsibleUserId((int) $array['responsible_user_id']);
        $this->setTags($array['tags']);
        $this->fields->fromArray($array['custom_fields'] ? : [], Field::LEAD);
        return $this;
    }

    /**
     * 
     * @param type $array
     * @return \amoCRM\Lead
     */
    public static function createFromArray($array) {
        $Lead = new self($array['name']);
        $Lead->fromArray($array);
        return $Lead;
    }

    public static function createFromId($id) {
        $lead = new self;
        $lead->setId($id);
        $lead->isLoaded(FALSE);
        return $lead;
    }

    public function toArray() {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'request_id' => $this->requestId,
            'date_create' => $this->dateCreate->getTimestamp(),
            'last_modified' => $this->lastModified->getTimestamp(),
            'status_id' => $this->statusId,
            'price' => $this->price,
            'responsible_user_id' => $this->responsibleUserId,
            'custom_fields' => $this->fields->toArray(),
            'tags' => $this->tags
        ];
        return array_filter($array, function($item) {
            return !is_null($item);
        });
    }

}
