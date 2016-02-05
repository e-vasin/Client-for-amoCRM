<?php

class amoCRM {

    public static $subdomain;

    public function getResponse($entity, array $query = [], array $data = []) {
        if (!isset($query['action'])) {
            throw new Exception('Не указано действие для запроса');
        }
        $action = $query['action'];
        unset($query['action']);
        $queryString = count($query) ? '/?' . http_build_query($query) : '';
        $link = "https://" . self::$subdomain . ".amocrm.ru/private/api/v2/json/$entity/$action" . $queryString;
        $options = [];
        if (count($data)) {
            $options = [
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data)
            ];
        }
        $response = $this->sendRequest($link, $options);
        return $response['response'];
    }

    protected function sendRequest($link, array $options = []) {
        $options_ = $options + [
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_USERAGENT => 'amoCRM-API-client/1.0',
            CURLOPT_HEADER => FALSE,
            CURLOPT_COOKIEFILE => __DIR__ . '/cookies/cookie.txt',
            CURLOPT_COOKIEJAR => __DIR__ . '/cookies/cookie.txt',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0
        ];
        $curl = curl_init();
        curl_setopt_array($curl, $options_);
        $response = json_decode(curl_exec($curl), TRUE); #Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        #Обрабатываем возможные ошибки
        if ($code != 200 && $code != 204) {
            $message = 'Код ответа: ' . $code . PHP_EOL
                    . 'Ответ:' . PHP_EOL . print_r($response, TRUE) . PHP_EOL
                    . 'Данные:' . PHP_EOL
                    . var_export(json_decode($options[CURLOPT_POSTFIELDS]), TRUE) . PHP_EOL;
            throw new \amoCRM\Exception($message, (int) $response['response']['error_code']);
        }
        curl_close($curl);
        return $response;
    }

}
