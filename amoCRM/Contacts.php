<?php

namespace amoCRM;

/**
 * @method \amoCRM\Contacts add(\amoCRM\Contact $contact) Description
 * @method \amoCRM\Contact item(integer $id) Description
 */
class Contacts extends Collection {
    
    use UpdatedCollection;
    
    /**
     * 
     * @param string $name
     * @return \amoCRM\Contact
     */
    public function createContact($name) {
        $contact = new Contact($name);
        $this->add($contact);
        return $contact;
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
            $response = $this->getResponse('contacts', $query);
            if (!is_array($response)) {
                break;
            }
            $array = array_merge($array, $response['contacts']);
            $query['limit_offset']+= $limit;
        } while (count($response['contacts']) === $limit);
        return $this->fromArray($array);
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
            $this->add(Contact::createFromArray($array));
        }
        return $this;
    }

    public static function createFromArray($array) {
        $Contacts = new self;
        $Contacts->fromArray($array);
        return $Contacts;
    }

}
