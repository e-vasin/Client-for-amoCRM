<?php

namespace amoCRM;

/**
 * @property-read integer $id Уникальный идентификатор контакта, который указывается с целью его обновления
 * @property-read integer $requestId Уникальный идентификатор записи в клиентской программе (не обязательный параметр)
 */
class Element {

    protected $id = NULL;
    protected $requestId = NULL;

    /**
     *
     * @var Collection
     */
    protected $collection;
    protected $isLoaded = TRUE;

    /**
     * 
     * @param integer $id
     * @return \amoCRM\Lead
     * 
     */
    public function setId($id) {
        $this->id = (int) $id;
        return $this;
    }

    public function setRequestId($id) {
        $this->requestId = (int) $id;
        return $this;
    }

    public function __get($property) {
        if (!property_exists($this, $property)) {
            throw new \Exception("Свойство $property не определено для " . get_class($this));
        }
        if ($property !== 'id' && !$this->isLoaded) {
            if (!$this->collection instanceof Collection) {
                throw new \Exception('Элементу ' . get_class($this) . ' не назначена коллекция!');
            }
            $entityName = strtolower(end(explode('\\', get_class($this->collection))));
            $array = $this->collection->getResponse($entityName, ['action' => 'list', 'id' => $this->id]);
            $this->fromArray($array[$entityName][0]);

            $this->isLoaded(TRUE);
        }
        return $this->$property;
    }

    public function setCollection(Collection $collection) {
        $this->collection = $collection;
        return $this;
    }

    protected function isLoaded($isLoaded) {
        $this->isLoaded = (bool) $isLoaded;
    }

    public static function createFromId($id) {
        $className = get_class($this);
        $element = new $className;
        $element->setId($id);
        return $element;
    }

}
