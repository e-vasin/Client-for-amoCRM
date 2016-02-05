<?php

namespace amoCRM;

/**
 * @property-read integer $elementId Уникальный идентификатор контакта или сделки 
 * @property-read integer $elementType Тип привязываемого елемента (1 - контакт, 2 - сделка)
 * @property-read \DateTime $dateCreate Дата создания данной задачи (не обязательный параметр)
 * @property-read \DateTime $lastModified Дата последнего изменения данной задачи (не обязательный параметр)
 * @property-read integer $taskType Тип задачи
 * @property-read string $text Текст задачи
 * @property-read integer $responsibleUserId Уникальный идентификатор ответственного пользователя
 * @property-read \DateTime $completeTill Дата до которой необходимо завершить задачу. Если указано время 23:59, то в интерфейсах системы вместо времени будет отображаться "Весь день"
 */
class Task extends Element {

    const CONTACT = 1;
    const LEAD = 2;

    protected $elementId;
    protected $elementType;
    protected $dateCreate;
    protected $lastModified;
    protected $taskType;
    protected $text;
    protected $responsibleUserId;
    protected $completeTill;
    
    public function __construct() {
        $this->dateCreate = new \DateTime();
        $this->lastModified = new \DateTime();
        $this->completeTill = new \DateTime();
        $this->completeTill->setTime(23, 59, 59);
        return $this;
    }
    
    /**
     * 
     * @param \amoCRM\Contact $contact
     * @return \amoCRM\Task
     * @throws Exception
     */
    public function setContact(Contact $contact) {
        if (!$contact->id) {
            throw new Exception('Не могу добавить контакт, не сохранённый на сервере. Сохраните контакт на сервере с помощью Contacts::upload()');
        }
        $this->setElementId($contact->id);
        $this->setElementType(Task::CONTACT);
        return $this;
    }
    
    /**
     * 
     * @param \amoCRM\Lead $lead
     * @return \amoCRM\Task
     * @throws Exception
     */
    public function setLead(Lead $lead) {
        if (!$lead->id) {
            throw new Exception('Не могу добавить задачу, не сохранённую на сервере. Сохраните задачу на сервере с помощью Leads::upload()');
        }
        $this->setElementId($lead->id);
        $this->setElementType(Task::LEAD);
        return $this;
    }

    /**
     * 
     * @param integer $elementId
     */
    public function setElementId($elementId) {
        $this->elementId = (int) $elementId;
    }

    /**
     * 
     * @param integer $elementType
     * @return \amoCRM\Task
     * @throws Exception
     */
    public function setElementType($elementType) {
        \validateType::isConstant($elementType, __CLASS__);
        $this->elementType = $elementType;
        return $this;
    }

    /**
     * 
     * @param \DateTime $dateCreate
     * @return \amoCRM\Task
     */
    public function setDateCreate(\DateTime $dateCreate) {
        $this->dateCreate = $dateCreate;
        return $this;
    }

    /**
     * 
     * @param \DateTime $lastModified
     * @return \amoCRM\Task
     */
    public function setLastModified(\DateTime $lastModified) {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * 
     * @param integer $taskType
     * @return \amoCRM\Task
     */
    public function setTaskType($taskType) {
        $this->taskType = (integer) $taskType;
        return $this;
    }

    /**
     * 
     * @param string $text
     * @return \amoCRM\Task
     */
    public function setText($text) {
        $this->text = (string) $text;
        return $this;
    }

    /**
     * 
     * @param integer $value
     * @return \amoCRM\Task
     */
    public function setResponsibleUserId($value) {
        $this->responsibleUserId = (int) $value;
        return $this;
    }

    /**
     * 
     * @param \DateTime $completeTill
     * @return \amoCRM\Task
     */
    public function setCompleteTill(\DateTime $completeTill) {
        $this->completeTill = $completeTill;
        return $this;
    }
    
    public function toArray() {
        $array = [
            'id' => $this->id,
            'request_id' => $this->requestId,
            'element_id' => $this->elementId,
            'element_type' => $this->elementType,
            'date_create' => $this->dateCreate->getTimestamp(),
            'last_modified' => $this->lastModified->getTimestamp(),
            'task_type' => $this->taskType,
            'text' => $this->text,
            'responsible_user_id' => $this->responsibleUserId,
            'complete_till' => $this->completeTill->getTimestamp()
        ];
        return array_filter($array, function($item) {
            return !is_null($item);
        });
    }

}
