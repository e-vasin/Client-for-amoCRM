<?php

namespace amoCRM;

/**
 * @method \amoCRM\Leads add(\amoCRM\Lead $lead) Description
 * @method \amoCRM\Lead item(integer $id) Description
 */
class Leads extends Collection {
    
    use UpdatedCollection;
    
    /**
     * 
     * @return \amoCRM\Lead
     */
    public function createLead() {
        $lead = new Lead();
        $this->add($lead);
        return $lead;
    }
    
    public function getList($query = ['action' => 'list'], $limit = 500, $offset = 0) {
        if ($query['action'] === 'list' && $limit > 0) {
            $query['limit_rows'] = $limit;
            if ($offset > 0) {
                $query['limit_offset'] = $offset;
            }
        }
        $array = [];
        do {
            $response = $this->getResponse('leads', $query);
            if (!is_array($response)) {
                break;
            }
            $array = array_merge($array, $response['leads']);
            $query['limit_offset']+= $limit;
        } while (count($response['leads']) === $limit);
        foreach ($array as $array) {
            $this->add(Lead::createfromArray($array));
        }
        return $this;
    }
    
    public function getFromId($id) {
        $query['action'] = 'list';
        $query['id'] = $id;
        return $this->getList($query);
    }

    public function getFromQuery($value, $limit = 500, $offset = 0) {
        $query['action'] = 'list';
        $query['query'] = $value;
        return $this->getList($query, $limit, $offset);
    }

    public function fromArray($array) {
        if (is_null($array)) {
            return $this;
        }
        \validateType::isArray($array);
        foreach ($array as $array) {
            $this->add(Lead::createFromArray($array));
        }
        return $this;
    }

    public static function createFromArray($array) {
        $leads = new self;
        $leads->fromArray($array);
        return $leads;
    }
    
    public function fromArrayId($array) {
        if (is_null($array)) {
            return $this;
        }
        \validateType::isArray($array);
        foreach ($array as $id) {
            $this->add(Lead::createFromId((int) $id));
        }
        return new self;
    }
    
    public function toArrayId() {
        $array = [];
        foreach ($this->elements as $element) {
            $array[] = (string) $element->id;
        }
        return $array;
    }
    
    public function mergeLeads(Leads $leads) {
        foreach ($leads as $lead) {
            /* @var $lead Lead */
            $this->add($lead);
        }
        return $this;
    }

}
