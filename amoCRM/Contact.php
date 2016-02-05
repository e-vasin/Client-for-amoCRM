<?php

namespace amoCRM;

/**
 * @property-read string $name Имя контакта
 * @property-read \DateTime $dateCreate Дата создания этого контакта (не обязательный параметр)
 * @property-read \DateTime $lastModified Дата последнего изменения этого контакта (не обязательный параметр)
 * @property-read integer $responsibleUserId Уникальный идентификатор ответственного пользователя
 * @property-read \amoCRM\Leads $leads Список связанных сделок
 * @property-read string $companyName Имя компании
 * @property-read \amoCRM\Fields $fields Дополнительные поля контакта
 * @property-read array $tags Массив тегов
 */
class Contact extends Element {

    const ACTION_ADD = 0;
    const ACTION_UPDATE = 1;

    protected $name;
    protected $dateCreate = NULL;
    protected $lastModified = NULL;
    protected $responsibleUserId = NULL;
    protected $leads;
    protected $companyName = NULL;
    protected $fields;
    protected $tags = NULL;

    /**
     * 
     * @param string $name
     * @return \amoCRM\Contact
     */
    public function __construct($name) {
        $this->leads = new Leads();
        $this->fields = new Fields();
        $this->dateCreate = new \DateTime();
        $this->lastModified = new \DateTime();
        return $this->setName($name);
    }

    /**
     * 
     * @param string $value
     * @return \amoCRM\Contact
     */
    public function setName($value) {
        $this->name = (string) $value;
        return $this;
    }

    /**
     * 
     * @param \amoCRM\Leads $leads
     * @return \amoCRM\Contact
     */
    public function setLeads(Leads $leads) {
//        if ($this->leads instanceof Leads) {
//            $this->leads->mergeLeads($leads);
//        } else {
            $this->leads = $leads;
//        }
        return $this;
    }

    /**
     * 
     * @param \DateTime $dateCreate
     * @return \amoCRM\Contact
     */
    public function setDateCreate(\DateTime $dateCreate) {
        $this->dateCreate = $dateCreate;
        return $this;
    }

    /**
     * 
     * @param \DateTime $lastModified
     * @return \amoCRM\Contact
     */
    public function setLastModified(\DateTime $lastModified) {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * 
     * @param integrt $value
     * @return \amoCRM\Contact
     */
    public function setResponsibleUserId($value) {
        $this->responsibleUserId = (integer) $value;
        return $this;
    }

    /**
     * 
     * @param type $value
     * @return \amoCRM\Contact
     */
    public function setCompanyName($value) {
        $this->companyName = (string) $value;
        return $this;
    }

    /**
     * 
     * @param \amoCRM\Fields $fields
     * @return \amoCRM\Contact
     */
    public function setFields(Fields $fields) {
        $this->fields = $fields;
        return $this;
    }

    /**
     * 
     * @param array $arrayTags
     * @return \amoCRM\Contact
     */
    public function setTags(array $arrayTags) {
        $this->tags = $arrayTags;
        return $this;
    }

    /**
     * 
     * @param array $array
     * @return \amoCRM\Contact
     * @throws Exception
     */
    public function fromArray(array $array) {
        if (!isset($array['type']) || (isset($array['type']) && $array['type'] !== 'contact')) {
            throw new \Exception('Этот массив не может быть использован для создания ' . __CLASS__ . '. Проверьте входные данные: ' . test($array));
        }
        $this->setId($array['id']);
        $this->setName($array['name']);
        $Date = new \DateTime();
        $this->setLastModified($Date->setTimestamp($array['last_modified']));
        $this->setDateCreate($Date->setTimestamp($array['date_create']));
        $this->setResponsibleUserId($array['responsible_user_id']);
        $this->leads->fromArrayId($array['linked_leads_id']);
        $this->setTags($array['tags']);
        $this->setCompanyName($array['company_name']);
        $this->fields->fromArray($array['custom_fields'], Field::CONTACT);
        return $this;
    }

    /**
     * 
     * @param type $array
     * @return \amoCRM\Contact
     */
    public static function createfromArray(array $array) {
        $Contact = new self($array['name']);
        $Contact->fromArray($array);
        return $Contact;
    }

    public function toArray() {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'request_id' => $this->requestId,
            'date_create' => $this->dateCreate->getTimestamp(),
            'last_modified' => $this->lastModified->getTimestamp(),
            'responsible_user_id' => $this->responsibleUserId,
            'linked_leads_id' => $this->leads->toArrayId(),
            'company_name' => $this->companyName,
            'custom_fields' => $this->fields->toArray(),
            'tags' => $this->tags
        ];
        return array_filter($array, function($item) {
            return !is_null($item);
        });
    }

}
