<?php

namespace amoCRM;

class Auth extends \amoCRM {

    private $user;

    public function __construct($subdomain, $user, $hash) {
        self::$subdomain = $subdomain;
        $this->user = ['USER_LOGIN' => $user, 'USER_HASH' => $hash];
        return $this;
    }

    public function getResponse() {
        $link = 'https://' . self::$subdomain . '.amocrm.ru/private/api/auth.php?type=json';
        $options = [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->user),
            CURLOPT_HTTPHEADER => array('Content-Type: application/json')
        ];
        $response = $this->sendRequest($link, $options);
        return $response['response'];
    }

    public function isAuth() {
        $response = $this->getResponse();
        return isset($response['auth']);
    }

}
