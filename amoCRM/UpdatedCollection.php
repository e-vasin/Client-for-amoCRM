<?php

namespace amoCRM;

trait UpdatedCollection {

    public function toArray() {
        $array = [];
        $i = 1;
        foreach ($this->elements as $element) {
            if ($element->id) {
                $action = 'update';
            } else {
                $action = 'add';
                $element->setRequestId( ++$i);
            }
            $array[$action][] = $element->toArray();
        }
        return $array;
    }

    public function upload() {
        $entityName = strtolower(end(explode('\\', __CLASS__)));
        $data['request'][$entityName] = $this->toArray();
        $response = $this->getResponse($entityName, ['action' => 'set'], $data);
        if (isset($response[$entityName]['add'])) {
            foreach ($response[$entityName]['add'] as $array) {
                foreach ($this->elements as $element) {
                    if ($element->requestId === (int) $array['request_id']) {
                        $element->setId($array['id']);
                        break;
                    }
                }
            }
        }
        return $this;
    }

}
